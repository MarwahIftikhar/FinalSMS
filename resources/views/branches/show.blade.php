@extends('adminlte::page')
@section('title', $branch->name)
@section('content_header')<h1>{{ $branch->name }}</h1>@stop
@section('content')<div class="card module-card"><div class="card-body"><p><strong>Location:</strong> {{ $branch->location }}</p><p><strong>Status:</strong> {{ $branch->status ? 'Active' : 'Inactive' }}</p><a href="{{ route('branches.edit', $branch) }}" class="btn btn-primary">Edit Branch</a> <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">Back</a></div></div>@stop
