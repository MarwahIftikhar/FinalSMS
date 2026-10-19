<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Branch;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(Request $request): View
    {
        $email = $request->query('email');
        $user = $email ? User::where('email', $email)->first() : null;

        $isSuperAdmin = (bool) ($user && $user->isSuperAdmin());
        $branches = $isSuperAdmin
            ? Branch::where('status', true)->orderBy('name')->get()
            : collect();

        return view('auth.login', compact('isSuperAdmin', 'branches'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
        ]);

        // branch_id is NOT a credential — keep it out of the auth query.
        $branchId = $validated['branch_id'] ?? null;
        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        // Debug logging
        Log::info('Login attempt', ['email' => $credentials['email']]);
        
        $user = User::where('email', $credentials['email'])->first();
        if ($user) {
            Log::info('User found', [
                'id' => $user->id,
                'name' => $user->name,
                'branch_id' => $user->branch_id,
                'is_admin' => $user->is_admin,
            ]);
            $passwordMatches = Hash::check($credentials['password'], $user->password);
            Log::info('Password check', ['matches' => $passwordMatches]);
        } else {
            Log::info('User not found for email: ' . $credentials['email']);
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            Log::warning('Authentication failed', ['email' => $credentials['email']]);
            return back()->withErrors(['email' => 'These credentials are incorrect.'])
                ->onlyInput('email');
        }

        Log::info('Authentication successful', ['email' => $credentials['email']]);
        $request->session()->regenerate();

        // Only a super admin may choose the login branch (enforced server-side,
        // the select is hidden in the UI for everyone else).
        $user = Auth::user();
    if ($user instanceof User && $user->isSuperAdmin() && $branchId) {
            $branchIsActive = Branch::where('id', $branchId)->where('status', true)->exists();

            if ($branchIsActive) {
                $request->session()->put('active_branch_id', (int) $branchId);
            }
        }

        return redirect()->intended('/');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
