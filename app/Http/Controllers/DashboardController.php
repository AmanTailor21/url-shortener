<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ShortUrl;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->role === 'SuperAdmin') {
            $clients = Company::withCount('users')->latest()->take(5)->get();
            return view('dashboard.super-admin', compact('clients'));
        }
        $company = $user->company;
        $users = $company ? $company->users()->latest()->take(5)->get() : collect();
        $urls = ShortUrl::with('user')->where('company_id', $user->company_id)
            ->when(in_array($user->role, ['Admin', 'Member']), fn($q) => $q->where('user_id', '!=', $user->id))
            ->latest()->take(10)->get();
        return view('dashboard.client', compact('company', 'users', 'urls'));
    }
}
