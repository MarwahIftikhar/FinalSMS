@extends('adminlte::page')
@section('title', 'Add Section')
@section('content_header')<h1>Add Section</h1>@stop
@section('content')@include('sections.form', ['section' => null, 'formAction' => route('sections.store'), 'formMethod' => 'POST', 'submitLabel' => 'Create Section'])@stop
