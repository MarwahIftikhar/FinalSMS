@extends('adminlte::page')

@section('title', 'Edit Admission')

@section('content_header')
    <div class="module-page-header">
        <div>
            <span class="module-page-header__eyebrow">Admissions</span>
            <h1>Edit Student Admission</h1>
            <p>Review and update the student's admission information.</p>
        </div>
        <i class="bi bi-pencil-square fs-1 text-white-50"></i>
    </div>
@stop

@section('content')
    @include('admissions.form', [
        'admission' => $admission,
        'formAction' => route('admissions.update', $admission),
        'formMethod' => 'PUT',
        'submitLabel' => 'Update Admission',
    ])
@stop

@section('js')
    @vite('resources/js/app.js')
@stop
