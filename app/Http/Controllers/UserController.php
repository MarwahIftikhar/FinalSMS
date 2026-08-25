<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('users.index', [
            'users' => User::with('branch')->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('users.create', ['branches' => Branch::where('status', true)->orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        User::create($this->validatedData($request));

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user, 'branches' => Branch::where('status', true)->orderBy('name')->get()]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update($this->validatedData($request, $user));

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    private function validatedData(Request $request, ?User $user = null): array
    {
        $passwordRules = $user
            ? ['nullable', 'string', 'min:8', 'confirmed']
            : ['required', 'string', 'min:8', 'confirmed'];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'password' => $passwordRules,
            'is_admin' => ['required', 'boolean'],
            'branch_id' => ['required', 'integer', 'exists:branches,id'],
        ]);

        if ($user && blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        return $validated;
    }
}
