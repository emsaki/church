<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        /* ======================================
         | FORCE PASSWORD CHANGE (FIRST LOGIN)
         * ====================================== */
        if ($user->must_change_password) {
            return redirect()->route('password.change');
        }

        /* ======================================
         | ROLE / STATUS CHECKS
         * ====================================== */

        // Admin
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Priest but deactivated
        if (
            $user->hasRole('priest') &&
            $user->priest &&
            ! $user->priest->active
        ) {
            Auth::logout();

            return redirect()->route('login')
                ->withErrors(['email' => 'Your priest account is deactivated.']);
        }

        // Priest
        if ($user->hasRole('priest')) {
            return redirect()->route('priest.dashboard');
        }

        // SCC Leader
        if ($user->hasRole('scc_leader')) {
            return redirect()->route('leader.dashboard');
        }

        // Fallback
        return redirect()->route('dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}