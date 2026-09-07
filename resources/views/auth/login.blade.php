@extends('layouts.guest')
@section('content')
<h5 class="text-center mb-4">Sign in to your account</h5>
<form method="POST" action="{{ route('login.store') }}">
    @csrf
    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus></div>
    <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
    <div class="form-check mb-3"><input type="checkbox" name="remember" value="1" class="form-check-input" id="remember"><label for="remember" class="form-check-label">Remember me</label></div>
    <button class="btn btn-primary w-100">Login</button>
</form>
<div class="demo-login mt-4">Super Admin: superadmin@example.com / password</div>
@endsection
