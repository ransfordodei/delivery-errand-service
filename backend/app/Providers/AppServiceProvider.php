<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // explicitly load route files in absence of RouteServiceProvider
        if (file_exists(base_path('routes/web.php'))) {
            \Illuminate\Support\Facades\Route::middleware('web')
                ->group(base_path('routes/web.php'));
        }
        if (file_exists(base_path('routes/api.php'))) {
            \Illuminate\Support\Facades\Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        }
    }
}
