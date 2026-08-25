@extends('adminlte::page')
@section('title', $section->name)
@section('content_header')<h1>{{ $section->name }}</h1>@stop
@section('content')<div class="card"><div class="card-body"><p><strong>Description:</strong> {{ $section->description ?: '-' }}</p><p><strong>Status:</strong> {{ $section->status ? 'Active' : 'Inactive' }}</p><a href="{{ route('sections.edit', $section) }}" class="btn btn-primary">Edit Section</a> <a href="{{ route('sections.index') }}" class="btn btn-outline-secondary">Back</a></div></div>@stop
