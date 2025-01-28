<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para administradores
        Gate::define('is-admin', function ($user) {
            return $user->role === 'admin'; // Ajusta el campo de rol según tu base de datos
        });

        // Gate para clientes
        Gate::define('is-client', function ($user) {
            return $user->role === 'cliente'; // Ajusta el campo de rol según tu base de datos
        });
    }
}
