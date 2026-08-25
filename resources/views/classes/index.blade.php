@extends('adminlte::page')

@section('title', 'Classes')

@section('content_header')
    <div class="module-page-header">
        <div><span class="module-page-header__eyebrow">School Management System</span><h1>Classes</h1><p>Define and manage the classes available for student admissions.</p></div>
        <i class="bi bi-building fs-1 text-white-50"></i>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div id="flashToast" data-type="success" data-message="{{ session('success') }}"></div>
    @endif
    @if (session('error'))
        <div id="flashToast" data-type="error" data-message="{{ session('error') }}"></div>
    @endif

    <div class="card module-card">
        <div class="card-header d-flex align-items-center"><h3 class="card-title mb-0">Class List</h3><button type="button" class="btn btn-light text-primary fw-semibold ms-auto" data-bs-toggle="modal" data-bs-target="#addClassCrudModal"><i class="bi bi-plus-lg me-1"></i> Add Class</button></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 module-table">
                    <thead>
                        <tr><th>Name</th><th>Description</th><th>Status</th><th class="text-end">Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($classes as $schoolClass)
                            <tr>
                                <td>{{ $schoolClass->name }}</td>
                                <td>{{ $schoolClass->description ?: '-' }}</td>
                                <td>
                                    <span class="badge {{ $schoolClass->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $schoolClass->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('classes.edit', $schoolClass) }}" class="btn btn-sm btn-primary" title="Edit class">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('classes.destroy', $schoolClass) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this class? Classes attached to admissions cannot be deleted.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete class">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4">No classes have been created yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addClassCrudModal" tabindex="-1" aria-labelledby="addClassCrudModalLabel" aria-hidden="true">
        <div class="modal-dialog"><form id="addClassCrudForm" class="modal-content" data-url="{{ route('classes.storeFromAdmission') }}">
            @csrf
            <div class="modal-header"><h5 class="modal-title" id="addClassCrudModalLabel">Add New Class</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body"><div id="classCrudMessage" class="alert d-none" role="alert"></div><div class="mb-3"><label for="crud_class_name" class="form-label">Class Name <span class="text-danger">*</span></label><input id="crud_class_name" name="name" class="form-control" required><div id="crud_class_name_error" class="invalid-feedback"></div></div><div class="mb-3"><label for="crud_class_description" class="form-label">Description</label><textarea id="crud_class_description" name="description" class="form-control" rows="2"></textarea></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create Class</button></div>
        </form></div>
    </div>
@stop

@section('js')
    @vite('resources/js/app.js')
@stop
