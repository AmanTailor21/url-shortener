<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $clients = Company::withCount('users')->latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:150'], 'email' => ['nullable', 'email', 'max:255']]);
        Company::create($data);
        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }
    
    public function show(Company $company)
    {
        $users = $company->users()->latest()->paginate(10);
        return view('clients.show', compact('company', 'users'));
    }
}
