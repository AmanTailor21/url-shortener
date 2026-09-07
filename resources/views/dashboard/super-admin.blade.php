@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-1">Clients</h5>
            <p class="text-muted mb-0">Manage client companies.</p>
        </div><a href="{{ route('clients.create') }}" class="btn btn-primary">Invite New Client</a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card"><span>Clients</span><strong>{{ $clients->count() }}</strong></div>
        </div>
        <div class="col-md-4">
            <div class="stat-card"><span>System Role</span><strong>Super Admin</strong></div>
        </div>
        <div class="col-md-4">
            <div class="stat-card"><span>URL Creation</span><strong>Disabled</strong></div>
        </div>
    </div>
    <div class="card table-card">
        <div class="card-header">Client Companies</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Users</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email ?: '-' }}</td>
                            <td>{{ $client->users_count }}</td>
                            <td><a href="{{ route('clients.show', $client) }}"
                                    class="btn btn-sm btn-outline-primary">View</a></td>
                    </tr>@empty<tr>
                            <td colspan="4" class="text-center py-4">No clients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
