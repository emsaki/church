<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('priest')) {
            return redirect()->route('priest.dashboard');
        }
        if ($user->hasRole('scc_leader')) {
            return redirect()->route('leader.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
