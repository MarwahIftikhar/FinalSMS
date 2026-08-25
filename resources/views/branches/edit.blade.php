@extends('adminlte::page')
@section('title', 'Edit Branch')
@section('content_header')<div class="module-page-header"><div><span class="module-page-header__eyebrow">Administration</span><h1>Edit Branch</h1><p>Update the branch name, location, or status.</p></div><i class="bi bi-pencil-square fs-1 text-white-50"></i></div>@stop
@section('content')@include('branches.form', ['branch' => $branch, 'formAction' => route('branches.update', $branch), 'formMethod' => 'PUT', 'submitLabel' => 'Update Branch'])@stop
