@extends('adminlte::page')
@section('title', 'Edit Section')
@section('content_header')<h1>Edit Section</h1>@stop
@section('content')@include('sections.form', ['section' => $section, 'formAction' => route('sections.update', $section), 'formMethod' => 'PUT', 'submitLabel' => 'Update Section'])@stop
