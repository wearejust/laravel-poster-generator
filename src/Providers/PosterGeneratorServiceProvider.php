<?php

namespace Just\PosterGenerator\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Just\PosterGenerator\Http\Middleware\GuardRenderURI;

class PosterGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Router $router
     */
    public function boot(Router $router)
    {
        $this->publishes([
            __DIR__ . '/../../config/poster.php' => config_path('poster.php'),
        ]);

        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/../../src/Http/routes.php';
        }

        $router->middleware('poster.render', GuardRenderURI::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/poster.php', 'poster'
        );
    }
}
