@extends('adminlte::page')

@section('title', 'New Admission')

@section('content_header')
    <div class="module-page-header">
        <div>
            <span class="module-page-header__eyebrow">Admissions</span>
            <h1>New Student Admission</h1>
            <p>Create a complete student record in three simple sections.</p>
        </div>
        <i class="bi bi-person-plus-fill fs-1 text-white-50"></i>
    </div>
@stop

@section('content')
    @include('admissions.form', [
        'admission' => null,
        'formAction' => route('admissions.store'),
        'formMethod' => 'POST',
        'submitLabel' => 'Save Admission',
    ])
@stop

@section('js')
    @vite('resources/js/app.js')
@stop
