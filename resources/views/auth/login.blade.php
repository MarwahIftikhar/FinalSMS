@extends('adminlte::page')
@section('title', 'Login')
@section('content_header')<h1>Sign in</h1>@stop
@section('content')
<div class="row justify-content-center"><div class="col-md-6"><div class="card module-card"><div class="card-header"><h3 class="card-title">Account Login</h3></div><div class="card-body">
@if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('login.store') }}">@csrf<div class="mb-3"><label for="email" class="form-label">Email</label><input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required autofocus></div><div class="mb-3"><label for="password" class="form-label">Password</label><input id="password" name="password" type="password" class="form-control" required></div><div class="form-check mb-3"><input id="remember" name="remember" type="checkbox" class="form-check-input"><label for="remember" class="form-check-label">Remember me</label></div><button class="btn btn-primary">Sign in</button></form>
<div class="alert alert-info mt-3 mb-0"><strong>Initial administrator:</strong><br>Email: test@example.com<br>Password: password</div>
</div></div></div></div>
@stop
