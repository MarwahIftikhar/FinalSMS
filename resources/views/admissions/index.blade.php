@extends('adminlte::page')

@section('title', 'Admissions')

@section('content_header')
    <div class="module-page-header">
        <div>
            <span class="module-page-header__eyebrow">School Management System</span>
            <h1>Student Admissions</h1>
            <p>Search, review, update, and manage student admission records.</p>
        </div>
        <i class="bi bi-mortarboard-fill fs-1 text-white-50"></i>
    </div>
@stop

@section('content')
    <div class="card module-card">
        <div class="card-header d-flex align-items-center">
            <h3 class="card-title mb-0">Student Admissions</h3>
            <a href="{{ route('admissions.create') }}" class="btn btn-light text-primary fw-semibold ms-auto">
                <i class="bi bi-person-plus me-1"></i> New Admission
            </a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div id="flashToast" data-type="success" data-message="{{ session('success') }}"></div>
            @endif
            @if (session('error'))
                <div id="flashToast" data-type="error" data-message="{{ session('error') }}"></div>
            @endif

            <div class="table-responsive">
                <table id="admissionsTable" class="table table-hover align-middle module-table" data-source="{{ route('admissions.index') }}">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Admission No.</th>
                            <th>Student Name</th>
                            <th>Father Name</th>
                            <th>Class / Section</th>
                            <th>Gender</th>
                            <th>Admission Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('js')
    @vite('resources/js/app.js')
@stop
