<?php

namespace Esatic\Suitecrm\Providers;

use Esatic\Suitecrm\Contracts\ApiCrmInterface;
use Esatic\Suitecrm\Facades\Suitecrm;
use Esatic\Suitecrm\Http\Controllers\AbstractController;
use Esatic\Suitecrm\Http\Controllers\CrmController;
use Esatic\Suitecrm\Http\Middleware\CrmMiddleware;
use Esatic\Suitecrm\Services\ApiCrm;
use Esatic\Suitecrm\Services\RelatedItems;
use Esatic\Suitecrm\Services\RelatedItemsInterface;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SuitecrmServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->addFacades();
        $this->addRoutes();
        /** @var Router $router */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('crm', CrmMiddleware::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations/');
        $this->publishes([__DIR__ . '/../migrations/' => database_path('migrations')], 'suitecrm');
        $this->publishes([__DIR__ . '/../config/suitecrm.php' => config_path('suitecrm.php')], 'suitecrm');
        $this->mergeConfigFrom(__DIR__ . '/../config/suitecrm.php', 'suitecrm');
    }

    protected function addFacades()
    {
        $this->app->bind(Suitecrm::FACADE, ApiCrm::class);
        $this->app->bind(AbstractController::class, CrmController::class);
        $this->app->bind(ApiCrmInterface::class, ApiCrm::class);
        $this->app->bind(RelatedItemsInterface::class, RelatedItems::class);
    }

    protected function addRoutes()
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../routes/api.php');
    }
}
