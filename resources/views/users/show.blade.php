@extends('adminlte::page')

@section('title', $user->name)

@section('content_header')<h1>{{ $user->name }}</h1>@stop

@section('content')
    <div class="card"><div class="card-body">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Branch:</strong> {{ $user->branch?->name ?: '-' }}</p>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit User</a>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Back</a>
    </div></div>
@stop
