<?php

namespace App\Providers;

use Laravel\Fortify\Contracts\RegisterResponse;
use App\Responses\RegisterResponse as CustomRegisterResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(RegisterResponse::class, CustomRegisterResponse::class);
    }
}
