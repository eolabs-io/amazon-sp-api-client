<?php

namespace EolabsIo\AmazonSpApiClient\Tests;

use EolabsIo\AmazonSpApiClient\AmazonSpApiClientServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(realpath(dirname(__DIR__).'/database/migrations'));
    }

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            AmazonSpApiClientServiceProvider::class,
        ];
    }
    /**
     * Get package aliases.  In a normal app environment these would be added to
     * the 'aliases' array in the config/app.php file.  If your package exposes an
     * aliased facade, you should add the alias here, along with aliases for
     * facades upon which your package depends, e.g. Cartalyst/Sentry.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    // protected function getPackageAliases($app)
    // {
    //     return [
    //         // 'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
    //     ];
    // }


    /**
     * @param \Illuminate\Foundation\Application $app
     */
    // protected function getEnvironmentSetUp($app)
    // {

    // }
}
