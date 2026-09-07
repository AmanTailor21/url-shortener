@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><div><h5 class="mb-1">Generated Short URLs</h5><p class="text-muted mb-0">URLs visible according to your role.</p></div>@if(in_array(auth()->user()->role, ['Sales','Manager']))<a href="{{ route('short-urls.create') }}" class="btn btn-primary">Generate</a>@endif</div>
<form method="GET" action="{{ route('short-urls.index') }}" class="d-flex flex-wrap align-items-end gap-2 mb-3">
	<div><label for="period" class="form-label mb-1">View and Download based on Date Interval</label><select id="period" name="period" class="form-select"><option value="this_month" @selected($period === 'this_month')>This Month</option><option value="last_month" @selected($period === 'last_month')>Last Month</option><option value="last_week" @selected($period === 'last_week')>Last Week</option><option value="today" @selected($period === 'today')>Today</option></select></div>
	<button type="submit" class="btn btn-outline-primary">Filter</button>
	<a href="{{ route('short-urls.download', ['period' => $period]) }}" class="btn btn-primary">Download</a>
</form>
<div class="card table-card"><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Short URL</th><th>Long URL</th><th>Hits</th><th>Created By</th><th>Created</th></tr></thead><tbody>@forelse($urls as $url)<tr><td><a href="{{ route('short-urls.redirect', $url->short_code) }}">{{ url('/s/'.$url->short_code) }}</a></td><td class="truncate">{{ $url->long_url }}</td><td>{{ $url->hits }}</td><td>{{ $url->user->name }}</td><td>{{ $url->created_at->format('d M Y') }}</td></tr>@empty<tr><td colspan="5" class="text-center py-4">No short URLs found.</td></tr>@endforelse</tbody></table></div><div class="p-3">{{ $urls->links() }}</div></div>
@endsection
