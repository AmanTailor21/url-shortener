@extends('layouts.app')
@section('content')
    <div class="form-card">
        <h5>Invite Team Member</h5>
        <p class="text-muted">An invitation link will be generated after submission.</p>
        <form method="POST" action="{{ route('users.invite.store') }}">@csrf
            <div class="mb-3"><label class="form-label">Company</label><select name="company_id" class="form-select" required>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @selected(old('company_id', auth()->user()->company_id) == $company->id)>{{ $company->name }}</option>
                    @endforeach
                </select></div>
            <div class="mb-3"><label class="form-label">Name</label><input name="name" value="{{ old('name') }}"
                    class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email"
                    value="{{ old('email') }}" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Role</label><select name="role" class="form-select" required>
                    <option value="Sales">Sales</option>
                    <option value="Manager">Manager</option>
                    <option value="Member">Member</option>
                    <option value="Admin">Admin</option>
                </select></div>
            <button class="btn btn-primary">Send Invitation</button>
        </form>
    </div>
@endsection
