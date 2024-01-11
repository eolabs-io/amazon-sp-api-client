<?php

namespace EolabsIo\AmazonSpApiClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EolabsIo\AmazonSpApiClient\Auth\Auth
 */
class Auth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'amazon-sp-api-auth';
    }
}
