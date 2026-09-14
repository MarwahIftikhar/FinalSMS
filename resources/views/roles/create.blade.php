@extends('adminlte::page')
@section('title', 'Create Role')
@section('content_header')<div class="module-page-header"><div><span class="module-page-header__eyebrow"><a href="{{ route('roles.index') }}">Roles</a></span><h1>Create Role</h1><p>Add a new role to your system.</p></div><i class="bi bi-shield-plus fs-1 text-white-50"></i></div>@stop
@section('content')
@include('roles.form', [
    'role' => null,
    'formAction' => route('roles.store'),
    'formMethod' => 'POST',
    'submitLabel' => 'Create Role',
])
@stop
@section('js')@vite('resources/js/app.js')@stop
