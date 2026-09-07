<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUserRequest;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InvitationController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();
        $companies = $user->role === 'SuperAdmin' ? Company::orderBy('name')->get() : collect([$user->company]);
        return view('users.invite', compact('companies'));
    }
    
    public function store(InviteUserRequest $request)
    {
        $user = $request->user();
        $company = Company::findOrFail($request->company_id);
        if ($user->role === 'Admin') {
            if ($company->id !== $user->company_id) abort(403);
            if (in_array($request->role, ['Admin', 'Member'], true)) {
                return back()->withErrors(['role' => 'Admin cannot invite another Admin or Member.'])->withInput();
            }
        }
        if ($user->role === 'SuperAdmin' && $request->role === 'Admin' && $company->users()->count() === 0) {
            return back()->withErrors(['role' => 'SuperAdmin cannot invite an Admin into a new company.'])->withInput();
        }
        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'This email is already registered.'])->withInput();
        }
        $invitation = Invitation::create([
            'company_id' => $company->id,
            'invited_by' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'token' => Str::random(64),
            'expires_at' => now()->addDays(2),
        ]);
        return redirect()->route('dashboard')->with('invitation_link', route('invitations.accept.form', $invitation->token));
    }

    public function acceptForm(string $token)
    {
        $invitation = Invitation::where('token', $token)->whereNull('accepted_at')->where('expires_at', '>', now())->firstOrFail();
        return view('invitations.accept', compact('invitation'));
    }

    public function accept(Request $request, string $token)
    {
        $request->validate(['password' => ['required', 'string', 'min:8', 'confirmed']]);
        $invitation = Invitation::where('token', $token)->whereNull('accepted_at')->where('expires_at', '>', now())->first();
        if (!$invitation) throw ValidationException::withMessages(['token' => 'Invitation is invalid or expired.']);
        if (User::where('email', $invitation->email)->exists()) throw ValidationException::withMessages(['token' => 'This invitation email is already registered.']);
        User::create([
            'company_id' => $invitation->company_id,
            'name' => $invitation->name,
            'email' => $invitation->email,
            'password' => Hash::make($request->password),
            'role' => $invitation->role,
        ]);
        $invitation->update(['accepted_at' => now()]);
        return redirect()->route('login')->with('success', 'Invitation accepted. You can now log in.');
    }
}
