<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'URL Shortener' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">URL Shortener</div>
        <div class="user-box">
            <div class="fw-semibold">{{ auth()->user()->name }}</div>
            <div class="small text-muted">{{ auth()->user()->role }}</div>
        </div>
        <nav>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            @if(auth()->user()->role === 'SuperAdmin')
                <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">Clients</a>
            @endif
            @if(auth()->user()->role !== 'SuperAdmin')
                <a href="{{ route('short-urls.index') }}" class="nav-link {{ request()->routeIs('short-urls.index') ? 'active' : '' }}">Generated Short URLs</a>
            @endif
            @if(in_array(auth()->user()->role, ['Sales', 'Manager']))
                <a href="{{ route('short-urls.create') }}" class="nav-link">Generate Short URL</a>
            @endif
            @if(in_array(auth()->user()->role, ['SuperAdmin', 'Admin']))
                <a href="{{ route('users.invite') }}" class="nav-link">Invite User</a>
            @endif
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button class="btn btn-outline-secondary w-100">Logout</button>
        </form>
    </aside>
    <main class="main-content">
        <div class="topbar">
            <div>
                <h4 class="mb-0">{{ $title ?? 'Dashboard' }}</h4>
                <div class="small text-muted">URL Shortener Management</div>
            </div>
            <span class="badge text-bg-light">{{ auth()->user()->role }}</span>
        </div>
        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('invitation_link'))
                <div class="alert alert-info">
                    <div class="fw-semibold mb-1">Invitation link</div>
                    <div class="small text-break">{{ session('invitation_link') }}</div>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
