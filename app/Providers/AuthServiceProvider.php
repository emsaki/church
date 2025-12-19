<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Gate::define('is-admin', fn($user) => $user->hasRole('admin'));
        Gate::define('is-priest', fn($user) => $user->hasRole('priest'));
        Gate::define('is-scc-leader', fn($user) => $user->hasRole('scc_leader'));
        Gate::define('is-any-role', fn($user) => true);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '', 'https') !== false) {
            URL::forceScheme('https');
        }
    }
}
