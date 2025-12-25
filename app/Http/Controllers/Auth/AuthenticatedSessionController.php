<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid credentials provided.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // ROLE-BASED REDIRECT
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        if (auth()->user()->role === 'priest' && !$user->priest->active) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your priest account is deactivated.']);
        }

        if ($user->hasRole('priest')) {
            return redirect()->route('priest.dashboard');
        }
        if ($user->hasRole('scc_leader')) {
            return redirect()->route('leader.dashboard');
        }

        return redirect()->route('dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}