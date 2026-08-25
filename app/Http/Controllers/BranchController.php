<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function index(): View
    {
        return view('branches.index', [
            'branches' => Branch::withCount(['admissions', 'classes', 'sections', 'users'])->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('branches.create');
    }

    public function switch(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'branch_id' => ['required', 'integer', 'exists:branches,id'],
        ]);

        abort_unless(Branch::where('id', $data['branch_id'])
            ->where('status', true)
            ->exists(), 404);

        $request->session()->put('active_branch_id', (int) $data['branch_id']);

        return back()->with('success', 'Active branch changed successfully.');
    }

    public function store(Request $request): RedirectResponse
    {
        Branch::create($this->validatedData($request));

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function show(Branch $branch): View
    {
        return view('branches.show', compact('branch'));
    }

    public function edit(Branch $branch): View
    {
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch): RedirectResponse
    {
        $branch->update($this->validatedData($request, $branch));

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        if ($branch->admissions()->exists() || $branch->classes()->exists() || $branch->sections()->exists() || $branch->users()->exists()) {
            return redirect()->route('branches.index')
            ->with('error', 'This branch cannot be deleted because it has connected admissions, classes, sections, or users.');
        }

        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Branch deleted successfully.');
    }

    private function validatedData(Request $request, ?Branch $branch = null): array
    {
        return $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('branches', 'name')->ignore($branch?->id),
            ],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
        ]);
    }
}
