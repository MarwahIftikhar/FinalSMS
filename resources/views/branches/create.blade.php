@extends('adminlte::page')
@section('title', 'Add Branch')
@section('content_header')<div class="module-page-header"><div><span class="module-page-header__eyebrow">Administration</span><h1>Add Branch</h1><p>Create a new school location for branch-specific records.</p></div><i class="bi bi-diagram-3-fill fs-1 text-white-50"></i></div>@stop
@section('content')@include('branches.form', ['branch' => null, 'formAction' => route('branches.store'), 'formMethod' => 'POST', 'submitLabel' => 'Create Branch'])@stop
