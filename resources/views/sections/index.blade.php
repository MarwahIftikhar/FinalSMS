@extends('adminlte::page')

@section('title', 'Sections')
@section('content_header')
<div class="module-page-header"><div><span class="module-page-header__eyebrow">School Management System</span><h1>Sections</h1><p>Define and manage the sections available for student admissions.</p></div><i class="bi bi-diagram-3 fs-1 text-white-50"></i></div>
@stop

@section('content')
@if (session('success'))<div id="flashToast" data-type="success" data-message="{{ session('success') }}"></div>@endif
@if (session('error'))<div id="flashToast" data-type="error" data-message="{{ session('error') }}"></div>@endif
<div class="card module-card"><div class="card-header d-flex align-items-center"><h3 class="card-title mb-0">Section List</h3><a href="{{ route('sections.create') }}" class="btn btn-light text-primary fw-semibold ms-auto"><i class="bi bi-plus-lg me-1"></i> Add Section</a></div><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0 module-table"><thead><tr><th>Name</th><th>Description</th><th>Status</th><th>Admissions</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse ($sections as $section)<tr><td>{{ $section->name }}</td><td>{{ $section->description ?: '-' }}</td><td><span class="badge {{ $section->status ? 'bg-success' : 'bg-secondary' }}">{{ $section->status ? 'Active' : 'Inactive' }}</span></td><td>@if ($section->admissions_count)<span class="badge bg-warning text-dark">{{ $section->admissions_count }} assigned</span><div class="small text-muted mt-1">Remove it from admissions before changing.</div>@else<span class="text-muted">None</span>@endif</td><td class="text-end"><a href="{{ route('sections.edit', $section) }}" class="btn btn-sm btn-primary" title="Edit section"><i class="bi bi-pencil-square"></i></a>@if ($section->admissions_count)<button type="button" class="btn btn-sm btn-secondary" disabled title="Cannot delete: section is attached to an admission"><i class="bi bi-lock-fill"></i></button>@else<form action="{{ route('sections.destroy', $section) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this section?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger" title="Delete section"><i class="bi bi-trash"></i></button></form>@endif</td></tr>@empty<tr><td colspan="5" class="text-center py-4">No sections have been created yet.</td></tr>@endforelse
</tbody></table></div></div></div>
@stop

@section('js')
	@vite('resources/js/app.js')
@stop
