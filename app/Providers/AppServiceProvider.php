<?php

namespace App\Providers;

use App\Mixins\JsonResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // // Telescope
    if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Response::mixin(new JsonResponse());

        // Instanciates JsonResponse Class with its methods. The third argument is whether you want your mixin to overide similar hard-coded mixins

    }
}
