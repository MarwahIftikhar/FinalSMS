<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('roles.index', [
            'roles' => Role::latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('roles.create', [
            'permissions' => Permission::all(),
        ]);
    }

   public function store(Request $request): RedirectResponse
{
    $request->merge([
        'name' => Str::snake(trim($request->input('name'))),
    ]);

    $data = $request->validate([
        'name' => [
            'required',
            'string',
            'unique:roles,name',
            'max:255',
        ],
        'permissions' => ['nullable', 'array'],
        'permissions.*' => ['exists:permissions,id'],
    ]);

    $role = Role::create([
        'name' => $data['name'],
        'guard_name' => 'web',
    ]);

    if (!empty($data['permissions'])) {
        $role->syncPermissions($data['permissions']);
    }

    return redirect()
        ->route('roles.index')
        ->with('success', 'Role created successfully.');
}
    public function show(Role $role): View
    {
        return view('roles.show', [
            'role' => $role,
            'permissions' => $role->permissions,
        ]);
    }

    public function edit(Role $role): View
    {
        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::all(),
            'rolePermissions' => $role->permissions->pluck('id')->toArray(),
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
{
    $protectedRoles = [
        'super_admin',
        'supervisor',
        'administrator',
    ];

    if (in_array($role->name, $protectedRoles)) {
        return redirect()
            ->route('roles.index')
            ->with('error', 'Default roles cannot be edited.');
    }

    $request->merge([
        'name' => Str::snake(trim($request->input('name'))),
    ]);

    $data = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            'unique:roles,name,' . $role->id,
        ],
        'permissions' => ['nullable', 'array'],
        'permissions.*' => ['exists:permissions,id'],
    ]);

    $role->update([
        'name' => $data['name'],
    ]);

    $role->syncPermissions($data['permissions'] ?? []);

    return redirect()
        ->route('roles.index')
        ->with('success', 'Role updated successfully.');
}

 public function destroy(Role $role): RedirectResponse
{
    $protectedRoles = [
        'super_admin',
        'supervisor',
        'administrator',
    ];

    if (in_array($role->name, $protectedRoles)) {
        return redirect()
            ->route('roles.index')
            ->with('error', 'Default roles cannot be deleted.');
    }

    if ($role->users()->exists()) {
        return redirect()
            ->route('roles.index')
            ->with('error', 'This role cannot be deleted because it is assigned to users.');
    }

    $role->delete();

    return redirect()
        ->route('roles.index')
        ->with('success', 'Role deleted successfully.');
}

    public function assignUserRole(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = \App\Models\User::findOrFail($data['user_id']);
        $role = Role::findOrFail($data['role_id']);

        $user->assignRole($role);

        return back()->with('success', 'Role assigned to user successfully.');
    }

    public function removeUserRole(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = \App\Models\User::findOrFail($data['user_id']);
        $role = Role::findOrFail($data['role_id']);

        $user->removeRole($role);

        return back()->with('success', 'Role removed from user successfully.');
    }
}
