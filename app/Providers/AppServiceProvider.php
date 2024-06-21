<?php

namespace App\Providers;

use App\Services\Omdb\OmdbApiService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

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
        $this->app->singleton(OmdbApiService::class, function (Application $app) {
            return new OmdbApiService();
        });
    }
}
