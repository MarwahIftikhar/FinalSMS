@extends('adminlte::page')

@section('title', 'Add Class')

@section('content_header')
    <h1>Add Class</h1>
@stop

@section('content')
    @include('classes.form', [
        'schoolClass' => null,
        'formAction' => route('classes.store'),
        'formMethod' => 'POST',
        'submitLabel' => 'Create Class',
    ])
@stop
