<?php

namespace Esatic\Suitecrm\Providers;

use Esatic\Suitecrm\Facades\Suitecrm;
use Esatic\Suitecrm\Services\CrmApi;
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
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([__DIR__ . '/../config/suitecrm.php' => config_path('suitecrm.php')], 'config');
        $this->mergeConfigFrom(__DIR__ . '/../config/suitecrm.php', 'suitecrm');
    }

    protected function addFacades()
    {
        $this->app->bind(Suitecrm::FACADE, CrmApi::class);
    }
}
