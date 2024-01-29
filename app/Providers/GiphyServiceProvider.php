<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GiphyService;

class GiphyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GiphyService::class, function ($app) {
            return new GiphyService(env('GIPHY_API_KEY'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
