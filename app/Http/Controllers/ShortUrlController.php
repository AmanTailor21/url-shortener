<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShortUrlRequest;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShortUrlController extends Controller
{
    public function index(Request $request)
    {
        $period = $this->validatedPeriod($request);
        $urls = $this->filteredUrls($request, $period)->latest()->paginate(10)->withQueryString();
        return view('short-urls.index', compact('urls', 'period'));
    }

    public function download(Request $request): StreamedResponse
    {
        $period = $this->validatedPeriod($request);
        $filename = 'short-urls-' . $period . '-' . now()->format('Y-m-d') . '.csv';
        $urls = $this->filteredUrls($request, $period)->latest()->get();

        return response()->streamDownload(function () use ($urls) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Short URL', 'Long URL', 'Hits', 'Created By', 'Created On']);

            foreach ($urls as $url) {
                fputcsv($handle, [
                    url('/s/' . $url->short_code),
                    $url->long_url,
                    $url->hits,
                    $url->user->name,
                    $url->created_at->format('d M Y H:i'),
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function filteredUrls(Request $request, string $period){
        $user = $request->user();
        if ($user->role === 'SuperAdmin') abort(403);

        [$from, $to] = match ($period) {
            'last_month' => [now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth()],
            'last_week' => [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()],
            'today' => [now()->startOfDay(), now()->endOfDay()],
            default => [now()->startOfMonth(), now()->endOfMonth()],
        };

        return ShortUrl::with('user')->where('company_id', $user->company_id)
            ->when(in_array($user->role, ['Admin', 'Member']), fn($q) => $q->where('user_id', '!=', $user->id))
            ->whereBetween('created_at', [$from, $to]);
    }

    private function validatedPeriod(Request $request): string
    {
        $period = $request->string('period')->toString();

        return in_array($period, ['this_month', 'last_month', 'last_week', 'today'], true)
            ? $period
            : 'this_month';
    }

    public function create(Request $request)
    {
        if (in_array($request->user()->role, ['Admin', 'Member', 'SuperAdmin'], true)) abort(403);
        return view('short-urls.create');
    }

    public function store(CreateShortUrlRequest $request)
    {
        $user = $request->user();
        if (!$user->company_id || in_array($user->role, ['Admin', 'Member', 'SuperAdmin'], true)) abort(403);
        do {
            $code = Str::random(8);
        } while (ShortUrl::where('short_code', $code)->exists());
        $shortUrl = ShortUrl::create(['company_id' => $user->company_id, 'user_id' => $user->id, 'long_url' => $request->long_url, 'short_code' => $code]);
        return redirect()->route('short-urls.index')->with('success', 'Short URL created: ' . url('/s/' . $shortUrl->short_code));
    }

    public function redirect(Request $request, string $code){
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();
        if (!$request->user()->company_id || $request->user()->company_id !== $shortUrl->company_id) abort(403);
        $shortUrl->increment('hits');
        return redirect()->away($shortUrl->long_url);
    }
}
