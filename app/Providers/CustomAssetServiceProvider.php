<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class CustomAssetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        URL::macro('asset', function ($path, $secure = null) {
            // Your custom implementation here
            // You can call the original asset function if needed
            // return \Illuminate\Support\Facades\URL::asset($path, $secure);

            // Or implement your own logic
            return 'public/' . $path;
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
