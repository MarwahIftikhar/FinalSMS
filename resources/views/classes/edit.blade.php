@extends('adminlte::page')

@section('title', 'Edit Class')

@section('content_header')
    <h1>Edit Class</h1>
@stop

@section('content')
    @include('classes.form', [
        'schoolClass' => $schoolClass,
        'formAction' => route('classes.update', $schoolClass),
        'formMethod' => 'PUT',
        'submitLabel' => 'Update Class',
    ])
@stop
