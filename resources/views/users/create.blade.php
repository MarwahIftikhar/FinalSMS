@extends('adminlte::page')

@section('title', 'Add User')

@section('content_header')<div class="module-page-header"><div><span class="module-page-header__eyebrow">Administration</span><h1>Add User</h1><p>Create a user and assign their branch.</p></div><i class="bi bi-person-plus-fill fs-1 text-white-50"></i></div>@stop

@section('content')
    @include('users.form', [
        'user' => null,
        'formAction' => route('users.store'),
        'formMethod' => 'POST',
        'submitLabel' => 'Create User',
    ])
@stop
