@extends('layouts.guest')
@section('content')
    <h5 class="text-center mb-2">Accept Invitation</h5>
    <p class="text-center text-muted mb-4">{{ $invitation->name }} · {{ $invitation->role }}</p>
    <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}">@csrf<div class="mb-3"><label
                class="form-label">Email</label><input class="form-control" value="{{ $invitation->email }}" disabled></div>
        <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password"
                class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Confirm Password</label><input type="password"
                name="password_confirmation" class="form-control" required></div><button
            class="btn btn-primary w-100">Create Account</button>
    </form>
@endsection
