@extends('adminlte::page')

@section('title', 'Roles')

@php
    $protectedRoles = [
        'super_admin',
        'supervisor',
        'administrator',
    ];
@endphp

@section('content_header')
    <div class="module-page-header">
        <div>
            <span class="module-page-header__eyebrow">
                Administration
            </span>

            <h1>Roles</h1>

            <p>Manage user roles and permissions.</p>
        </div>

        <i class="bi bi-shield-check fs-1 text-white-50"></i>
    </div>
@stop

@section('content')

    @if (session('success'))
        <div
            id="flashToast"
            data-type="success"
            data-message="{{ session('success') }}"
        ></div>
    @endif

    @if (session('error'))
        <div
            id="flashToast"
            data-type="error"
            data-message="{{ session('error') }}"
        ></div>
    @endif

    <div class="card module-card">
        <div class="card-header d-flex align-items-center">
            <h3 class="card-title mb-0">
                Role List
            </h3>

            <a
                href="{{ route('roles.create') }}"
                class="btn btn-light text-primary fw-semibold ms-auto"
            >
                <i class="bi bi-plus-lg me-1"></i>
                Add Role
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 module-table">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Users Count</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td>
                                    <strong>
                                        {{ \Illuminate\Support\Str::headline($role->name) }}
                                    </strong>
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $role->users()->count() }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <a
                                        href="{{ route('roles.show', $role) }}"
                                        class="btn btn-sm btn-info"
                                        title="View role"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (!in_array($role->name, $protectedRoles))
                                        <a
                                            href="{{ route('roles.edit', $role) }}"
                                            class="btn btn-sm btn-primary"
                                            title="Edit role"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form
                                            action="{{ route('roles.destroy', $role) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Delete this role?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Delete role"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-secondary"
                                            disabled
                                            title="Default role cannot be edited or deleted"
                                        >
                                            <i class="bi bi-lock-fill"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    No roles have been created yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('js')
    @vite('resources/js/app.js')
@stop