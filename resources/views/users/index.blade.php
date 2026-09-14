@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <div class="module-page-header"><div><span class="module-page-header__eyebrow">Administration</span><h1>Users</h1><p>Manage users and assign them to a school branch.</p></div><i class="bi bi-people-fill fs-1 text-white-50"></i></div>
@stop

@section('content')
    @if (session('success'))
        <div id="flashToast" data-type="success" data-message="{{ session('success') }}"></div>
    @endif

    <div class="card module-card">
        <div class="card-header d-flex align-items-center"><h3 class="card-title mb-0">User List</h3><a href="{{ route('users.create') }}" class="btn btn-light text-primary fw-semibold ms-auto"><i class="bi bi-person-plus me-1"></i> Add User</a></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 module-table">
                    <thead><tr><th>Name</th><th>Email</th><th>Branch</th><th>Role</th><th>Created</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->branch?->name ?: '-' }}</td>
                                <td>
                                    @if ($user->roles()->exists())
                                        <span class="badge bg-primary">{{ $user->roles()->first()?->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">No Role</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at?->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary" title="Edit user"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete user"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4">No users have been created yet.</td></tr>
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
