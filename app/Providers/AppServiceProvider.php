<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ADMIN
        Gate::define('gestionar-usuarios', function ($user) {
            return isset($user->roles_id) && $user->roles_id === 1;
        });

        // RESPONSABLE
        Gate::define('gestionar-responsable', function ($user) {
            return isset($user->roles_id) && $user->roles_id == 2;
        });

        // INSTRUCTOR
        Gate::define('gestionar-instructor', function ($user) {

            // Si es guard instructor
            if (Auth::guard('instructor')->check()) {
                return $user->participante && $user->participante->rol_id == 2;
            }

            return false;
        });

        Paginator::useBootstrap();
    }
}
