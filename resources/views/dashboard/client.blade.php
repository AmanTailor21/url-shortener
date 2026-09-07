@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-1">{{ $company?->name ?? 'Client Dashboard' }}</h5>
            <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}.</p>
        </div>
        @if (in_array(auth()->user()->role, ['Sales', 'Manager']))
            <a href="{{ route('short-urls.create') }}" class="btn btn-primary">Generate Short URL</a>
        @endif
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card"><span>Team Members</span><strong>{{ $company?->users()->count() ?? 0 }}</strong></div>
        </div>
        <div class="col-md-4">
            <div class="stat-card"><span>Visible URLs</span><strong>{{ $urls->count() }}</strong></div>
        </div>
        <div class="col-md-4">
            <div class="stat-card"><span>Your Role</span><strong>{{ auth()->user()->role }}</strong></div>
        </div>
    </div>
    <div class="card table-card mb-4">
        <div class="card-header d-flex justify-content-between"><span>Generated Short URLs</span><a
                href="{{ route('short-urls.index') }}">View All</a></div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Short URL</th>
                        <th>Long URL</th>
                        <th>Hits</th>
                        <th>Created By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($urls as $url)
                        <tr>
                            <td><a
                                    href="{{ route('short-urls.redirect', $url->short_code) }}">{{ url('/s/' . $url->short_code) }}</a>
                            </td>
                            <td class="truncate">{{ $url->long_url }}</td>
                            <td>{{ $url->hits }}</td>
                            <td>{{ $url->user->name }}</td>
                    </tr>@empty<tr>
                            <td colspan="4" class="text-center py-4">No URLs available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card table-card">
        <div class="card-header d-flex justify-content-between"><span>Team Members</span>
            @if (auth()->user()->role === 'Admin')
                <a href="{{ route('users.invite') }}">Invite</a>
            @endif
        </div>
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
                    @forelse($users as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td><span class="badge text-bg-light">{{ $member->role }}</span></td>
                    </tr>@empty<tr>
                            <td colspan="3" class="text-center py-4">No team members.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
