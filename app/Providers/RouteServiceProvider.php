<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
        $this->mapUserRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Load web routes.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->group(base_path('routes/web.php'));
    }

    /**
     * Load admin routes.
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware(['auth', 'admin'])
            ->prefix(config('app.admin_path'))
            ->as('admin.')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Load user routes.
     */
    protected function mapUserRoutes(): void
    {
        Route::middleware(['auth'])
            ->prefix('')
            ->as('user.')
            ->group(base_path('routes/user.php'));
    }

    /**
     * Load API routes.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));
    }
}
