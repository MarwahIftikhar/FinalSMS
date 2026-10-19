<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        return view('users.index', [
            'users' => User::with(['branch', 'roles'])->latest()->get(),
        ]);
    }

   public function create(): View
{
    return view('users.create', [
        'user' => null,
        'branches' => Branch::all(),
        'roles' => Role::where('guard_name', 'web')->get(),
        'userRole' => null,
    ]);
}

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $user = User::create($data);
        
        // Assign role if provided
        if (!empty($data['role_id'])) {
            $role = Role::findOrFail($data['role_id']);
            $user->assignRole($role);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user): View
    {
        $user->load(['branch', 'roles']);

        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
            'branches' => Branch::all(),
            'roles' => Role::where('guard_name', 'web')->get(),
            'userRole' => $user->roles->first(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validatedData($request, $user);
        $user->update($data);
        
        // Update user roles
        if (!empty($data['role_id'])) {
            $role = Role::findOrFail($data['role_id']);
            $user->syncRoles($role);
        } else {
            $user->syncRoles([]);
        }

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
            'role_id' => ['nullable', 'integer', 'exists:roles,id'],
            'is_admin' => ['nullable', 'boolean'],
            'branch_id' => ['required', 'integer', 'exists:branches,id'],
        ]);

        if ($user && blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        return $validated;
    }
}
