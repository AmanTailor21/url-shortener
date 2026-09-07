@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-1">{{ $company->name }}</h5>
            <div class="text-muted">{{ $company->email ?: 'No email' }}</div>
        </div><a href="{{ route('users.invite') }}" class="btn btn-primary">Invite User</a>
    </div>
    <div class="card table-card">
        <div class="card-header">Team Members</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                    </tr>@empty<tr>
                            <td colspan="3" class="text-center py-4">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $users->links() }}</div>
    </div>
@endsection
