@extends('layouts.app')
@section('content')
    <div class="form-card">
        <h5>Invite New Client</h5>
        <p class="text-muted">Create the client company first. Users can be invited after the company exists.</p>
        <form method="POST" action="{{ route('clients.store') }}">@csrf<div class="mb-3"><label class="form-label">Client
                    Name</label><input name="name" value="{{ old('name') }}" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email"
                    value="{{ old('email') }}" class="form-control"></div><button class="btn btn-primary">Create
                Client</button><a href="{{ route('clients.index') }}" class="btn btn-light ms-2">Cancel</a>
        </form>
    </div>
@endsection
