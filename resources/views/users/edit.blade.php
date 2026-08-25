@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')<div class="module-page-header"><div><span class="module-page-header__eyebrow">Administration</span><h1>Edit User</h1><p>Update the user account and branch assignment.</p></div><i class="bi bi-pencil-square fs-1 text-white-50"></i></div>@stop

@section('content')
    @include('users.form', [
        'user' => $user,
        'formAction' => route('users.update', $user),
        'formMethod' => 'PUT',
        'submitLabel' => 'Update User',
    ])
@stop
