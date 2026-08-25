<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::where('branch_id', $this->activeBranchId())->latest()->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('classes', 'name')->where('branch_id', $this->activeBranchId())],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        ClassModel::create($validated + ['branch_id' => $this->activeBranchId()]);

        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function storeFromAdmission(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('classes', 'name')->where('branch_id', $this->activeBranchId())],
            'description' => ['nullable', 'string'],
        ]);

        $schoolClass = ClassModel::create([
            'name' => trim($validated['name']),
            'description' => $validated['description'] ?? null,
            'status' => true,
            'branch_id' => $this->activeBranchId(),
        ]);

        return response()->json([
            'success' => true,
            'id' => $schoolClass->id,
            'name' => $schoolClass->name,
            'message' => 'Class "' . $schoolClass->name . '" created successfully.',
        ]);
    }

    public function show(ClassModel $schoolClass)
    {
        abort_unless($schoolClass->branch_id === $this->activeBranchId(), 404);
        return view('classes.show', compact('schoolClass'));
    }

    public function edit(ClassModel $schoolClass)
    {
        abort_unless($schoolClass->branch_id === $this->activeBranchId(), 404);
        return view('classes.edit', compact('schoolClass'));
    }

    public function update(Request $request, ClassModel $schoolClass)
    {
        abort_unless($schoolClass->branch_id === $this->activeBranchId(), 404);
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('classes', 'name')->ignore($schoolClass->id)->where('branch_id', $this->activeBranchId()),
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        $schoolClass->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(ClassModel $schoolClass)
    {
        abort_unless($schoolClass->branch_id === $this->activeBranchId(), 404);
        if ($schoolClass->admissions()->exists()) {
            return redirect()->route('classes.index')
                ->with('error', 'This class cannot be deleted because it is attached to an admission.');
        }

        $schoolClass->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Class deleted successfully.');
    }

    private function activeBranchId(): int
    {
        return (int) session('active_branch_id', 1);
    }
}
