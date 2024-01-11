<?php

namespace EolabsIo\AmazonSpApiClient;

use Illuminate\Support\ServiceProvider;
use EolabsIo\AmazonSpApiClient\Auth\Auth;
use EolabsIo\AmazonSpApiClient\AmazonSpApiHttp;

class AmazonSpApiClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if (AmazonSpApiClient::$runsMigrations) {
                $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
            }

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations/amazonSpApiClient'),
            ], 'amazon-sp-api-client-migrations');

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('amazon-sp-api-client.php'),
            ], 'amazon-sp-api-client-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'amazon-sp-api-client');

        // Register the main class to use with the facade
        $this->app->singleton('amazon-sp-api-http', function () {
            return new AmazonSpApiHttp;
        });

        $this->app->singleton('amazon-sp-api-auth', function () {
            return new Auth;
        });
    }
}
