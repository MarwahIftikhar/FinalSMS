@extends('adminlte::page')
@section('title', 'Edit Role')
@section('content_header')<div class="module-page-header"><div><span class="module-page-header__eyebrow"><a href="{{ route('roles.index') }}">Roles</a></span><h1>Edit Role: {{ $role->name }}</h1><p>Modify role details and permissions.</p></div><i class="bi bi-shield-check fs-1 text-white-50"></i></div>@stop
@section('content')
@include('roles.form', [
    'formAction' => route('roles.update', $role),
    'formMethod' => 'PUT',
    'submitLabel' => 'Update Role',
])
@stop
@section('js')@vite('resources/js/app.js')@stop
