<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(): View
    {
        return view('sections.index', [
            'sections' => Section::where('branch_id', $this->activeBranchId())->withCount('admissions')->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('sections.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Section::create($this->validatedData($request) + [
            'branch_id' => $this->activeBranchId(),
        ]);

        return redirect()->route('sections.index')
            ->with('success', 'Section created successfully.');
    }

    public function storeFromAdmission(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('sections', 'name')->where('branch_id', $this->activeBranchId())],
            'description' => ['nullable', 'string'],
        ]);

        $section = Section::create([
            'name' => trim($data['name']),
            'description' => $data['description'] ?? null,
            'status' => true,
            'branch_id' => $this->activeBranchId(),
        ]);

        return response()->json([
            'success' => true,
            'id' => $section->id,
            'name' => $section->name,
            'message' => 'Section "' . $section->name . '" created successfully.',
        ]);
    }

    public function show(Section $section): View
    {
        abort_unless($section->branch_id === $this->activeBranchId(), 404);
        return view('sections.show', compact('section'));
    }

    public function edit(Section $section): View
    {
        abort_unless($section->branch_id === $this->activeBranchId(), 404);
        return view('sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section): RedirectResponse
    {
        abort_unless($section->branch_id === $this->activeBranchId(), 404);
        $section->update($this->validatedData($request, $section));

        return redirect()->route('sections.index')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section): RedirectResponse
    {
        abort_unless($section->branch_id === $this->activeBranchId(), 404);
        if ($section->admissions()->exists()) {
            return redirect()
                ->route('sections.index')
                ->with('error', 'This section cannot be deleted because it is attached to an admission.');
        }

        $section->delete();

        return redirect()->route('sections.index')
            ->with('success', 'Section deleted successfully.');
    }

    private function validatedData(Request $request, ?Section $section = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sections', 'name')->ignore($section?->id)->where('branch_id', $this->activeBranchId()),
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);
    }

    private function activeBranchId(): int
    {
        return (int) session('active_branch_id', 1);
    }
}
