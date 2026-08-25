<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\ClassModel;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() || $request->has('draw')) {
            return DataTables::eloquent(
                Admission::with(['schoolClass', 'section', 'branch'])
                    ->where('branch_id', session('active_branch_id', 1))
                    ->latest()
            )
                ->addIndexColumn()

                ->addColumn('student_name', function (Admission $admission) {
                    $name = trim(
                        $admission->first_name . ' ' . $admission->last_name
                    );

                    return e($name);
                })

                ->addColumn('class_name', function (Admission $admission) {
                    $className = $admission->schoolClass
                        ? $admission->schoolClass->name
                        : 'N/A';

                    if ($admission->section) {
                        $className .= ' - ' . $admission->section->name;
                    }

                    return e($className);
                })

                ->editColumn('gender', function (Admission $admission) {
                    return e(ucfirst($admission->gender));
                })

                ->editColumn('status', function (Admission $admission) {
                    $badgeClass = $admission->status === 'Active'
                        ? 'bg-success'
                        : 'bg-secondary';

                    return '<span class="badge ' . $badgeClass . '">'
                        . e($admission->status)
                        . '</span>';
                })

                ->addColumn('actions', function (Admission $admission) {
                    $editUrl = route('admissions.edit', $admission);
                    $deleteUrl = route('admissions.destroy', $admission);
                    $admissionNumber = e($admission->admission_no);

                    return '
                        <a href="' . $editUrl . '"
                           class="btn btn-sm btn-primary me-1"
                           title="Edit admission">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <button type="button"
                                class="btn btn-sm btn-danger delete-admission"
                                data-delete-url="' . $deleteUrl . '"
                                data-admission-no="' . $admissionNumber . '"
                                title="Delete admission">
                            <i class="bi bi-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns([
                    'status',
                    'actions',
                ])

                ->toJson();
        }

        return view('admissions.index');
    }

    public function create()
    {
        $branchId = session('active_branch_id', 1);

        $classes = ClassModel::where('branch_id', $branchId)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        $sections = Section::where('branch_id', $branchId)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'admissions.create',
            compact('classes', 'sections')
        );
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $admission = Admission::create($data);

        return $this->successResponse(
            $request,
            'Student admission created successfully.',
            $admission
        );
    }

    public function edit(int $admission)
    {
        $admission = $this->branchAdmission($admission);

        $branchId = session('active_branch_id', 1);

        $classes = ClassModel::where(function ($query) use ($branchId, $admission) {
            $query->where('branch_id', $branchId)
                ->where('status', true)
                ->orWhere('id', $admission->class_id);
        })
            ->orderBy('name')
            ->get();

        $sections = Section::where(function ($query) use ($branchId, $admission) {
            $query->where('branch_id', $branchId)
                ->where('status', true)
                ->orWhere('id', $admission->section_id);
        })
            ->orderBy('name')
            ->get();

        return view(
            'admissions.edit',
            compact(
                'admission',
                'classes',
                'sections'
            )
        );
    }

    public function update(
        Request $request,
        int $admission
    ) {
        $admission = $this->branchAdmission($admission);

        $data = $this->validatedData(
            $request,
            $admission
        );

        $admission->update($data);

        return $this->successResponse(
            $request,
            'Student admission updated successfully.',
            $admission->fresh()
        );
    }

    public function destroy(
        Request $request,
        int $admission
    ) {
        $admission = $this->branchAdmission($admission);

        $admission->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Student admission deleted successfully.',
                'id' => $admission->id,
            ]);
        }

        return redirect()
            ->route('admissions.index')
            ->with(
                'success',
                'Student admission deleted successfully.'
            );
    }

    private function branchAdmission(int $id): Admission
    {
        return Admission::where(
            'branch_id',
            session('active_branch_id', 1)
        )->findOrFail($id);
    }

    private function validatedData(
        Request $request,
        ?Admission $admission = null
    ): array {
        $validated = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'gender' => [
                'required',
                Rule::in([
                    'male',
                    'female',
                ]),
            ],

            'date_of_birth' => [
                'required',
                'date',
            ],

            'nationality' => [
                'nullable',
                'string',
                'max:255',
            ],

            'admission_no' => [
                'required',
                'string',
                'max:255',
                Rule::unique(
                    'admissions',
                    'admission_no'
                )->ignore(
                    $admission?->id
                ),
            ],

            'admission_date' => [
                'required',
                'date',
            ],

            'class_id' => [
                'required',
                'integer',
                Rule::exists('classes', 'id')->where(function ($query) use ($admission) {
                    $query->where(
                        'branch_id',
                        session('active_branch_id', 1)
                    )
                        ->where('status', true);

                    if ($admission?->class_id) {
                        $query->orWhere(
                            'id',
                            $admission->class_id
                        );
                    }
                }),
            ],

            'section_id' => [
                'nullable',
                'integer',
                Rule::exists('sections', 'id')->where(function ($query) use ($admission) {
                    $query->where(
                        'branch_id',
                        session('active_branch_id', 1)
                    )
                        ->where('status', true);

                    if ($admission?->section_id) {
                        $query->orWhere(
                            'id',
                            $admission->section_id
                        );
                    }
                }),
            ],

            'father_name' => [
                'required',
                'string',
                'max:255',
            ],

            'mother_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'guardian_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'guardian_phone' => [
                'required',
                'string',
                'max:255',
            ],

            'guardian_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                Rule::in([
                    'Active',
                    'Inactive',
                ]),
            ],
        ]);

        $validated['branch_id'] = session(
            'active_branch_id',
            1
        );

        return $validated;
    }

    private function successResponse(
        Request $request,
        string $message,
        Admission $admission
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'admission' => $admission,
                'redirect_url' => route(
                    'admissions.index'
                ),
            ]);
        }

        return redirect()
            ->route('admissions.index')
            ->with(
                'success',
                $message
            );
    }
}