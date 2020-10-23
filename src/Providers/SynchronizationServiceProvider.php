<?php

namespace Davron112\Synchronizations\Providers;

use Davron112\Synchronizations\Jobs\ProductSynchronizationJob;
use Illuminate\Support\ServiceProvider;
use Davron112\Synchronizations\Jobs\Contracts\ProductSynchronizationJob as ProductSynchronizationJobInterface;


class SynchronizationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/synchronizations.php' => config_path('synchronizations.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../tests' => base_path('tests/synchronizations')
        ], 'tests');

        $this->app->bind('Davron112\Synchronizations\SynchronizationServiceInterface', function ($app) {
            $config  = $app['config']['synchronizations'];
            $service = $app->make('Davron112\Synchronizations\SynchronizationService');
            $service->setConfig($config);
            return $service;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductSynchronizationJobInterface::class, ProductSynchronizationJob::class);
    }
}