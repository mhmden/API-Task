<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Password Reset URI
        ResetPassword::createUrlUsing(function ($user, string $token) {
            // ? Returning my localhost is not best practice obviously
            return 'http://127.0.0.1:8000/api/reset-password?token='.$token;
            // return env('APP_URL').'/api/reset-password?token='.$token;
        });
    }
}
