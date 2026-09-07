@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Clients</h5><a href="{{ route('clients.create') }}" class="btn btn-primary">Invite New Client</a>
    </div>
    <div class="card table-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Users</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email ?: '-' }}</td>
                            <td>{{ $client->users_count }}</td>
                            <td>{{ $client->created_at->format('d M Y') }}</td>
                            <td><a class="btn btn-sm btn-outline-primary" href="{{ route('clients.show', $client) }}">View
                                    Users</a></td>
                    </tr>@empty<tr>
                            <td colspan="5" class="text-center py-4">No clients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $clients->links() }}</div>
    </div>
@endsection
