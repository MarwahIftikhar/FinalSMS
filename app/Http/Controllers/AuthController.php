<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

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
