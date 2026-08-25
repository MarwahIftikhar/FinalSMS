@extends('adminlte::page')

@section('title', $schoolClass->name)

@section('content_header')
    <h1>{{ $schoolClass->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Description:</strong> {{ $schoolClass->description ?: '-' }}</p>
            <p><strong>Status:</strong> {{ $schoolClass->status ? 'Active' : 'Inactive' }}</p>
            <a href="{{ route('classes.edit', $schoolClass) }}" class="btn btn-primary">Edit Class</a>
            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
@stop
