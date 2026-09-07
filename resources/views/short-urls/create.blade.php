@extends('layouts.app')
@section('content')
<div class="form-card"><h5>Generate Short URL</h5><p class="text-muted">Enter the original URL and generate a unique short URL.</p><form method="POST" action="{{ route('short-urls.store') }}">@csrf<div class="mb-3"><label class="form-label">Long URL</label><input type="url" name="long_url" value="{{ old('long_url') }}" class="form-control" placeholder="https://example.com/page" required></div><button class="btn btn-primary">Generate</button><a href="{{ route('short-urls.index') }}" class="btn btn-light ms-2">Cancel</a></form></div>
@endsection
