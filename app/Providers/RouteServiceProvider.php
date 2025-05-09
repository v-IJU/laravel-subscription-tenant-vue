<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = "/home";

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $centralDomains = $this->centralDomains();
        $this->routes(function () {
            // Route::middleware("api")
            //     ->prefix("api/v1")
            //     ->group(base_path("routes/apiv1.php"));

            // Route::middleware("web")->group(base_path("routes/web.php"));
            $this->mapApiRoutes();
            $this->mapWebRoutes();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for("api", function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    }

    protected function centralDomains(): array
    {
        if (config("app.env") == "local") {
            return config("tenancy.central_domains_local");
        } else {
            return config("tenancy.central_domains");
        }
    }
    protected function mapWebRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware("web")
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path("routes/web.php"));

            Route::middleware("web")
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path("routes/superadmin.php"));

            // if (file_exists(base_path("routes/superadmin.php"))) {
            //     Route::namespace(static::$controllerNamespace)->group(
            //         base_path("routes/superadmin.php")
            //     );
            // }
        }
    }

    protected function mapApiRoutes()
    {
        // foreach ($this->centralDomains() as $domain) {
        //     Route::prefix("api")
        //         ->domain($domain)
        //         ->middleware("api")
        //         ->namespace($this->namespace)
        //         ->group(base_path("routes/api.php"));
        // }
        Route::prefix("api/v1")
            ->middleware("api")
            ->namespace($this->namespace)
            ->group(base_path("routes/apiv1.php"));
    }
}
