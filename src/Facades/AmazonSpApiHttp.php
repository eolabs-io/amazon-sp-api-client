<?php

namespace EolabsIo\AmazonSpApiClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EolabsIo\AmazonSpApiClient\AmazonSpApiHttp
 */
class AmazonSpApiHttp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'amazon-sp-api-http';
    }
}
