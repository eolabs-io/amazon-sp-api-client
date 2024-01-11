<?php

namespace EolabsIo\AmazonSpApiClient\Models;

use EolabsIo\AmazonSpApiClient\Models\AmazonSpApiClientModel;
use EolabsIo\AmazonSpApiClient\Database\Factories\EndpointFactory;

class Endpoint extends AmazonSpApiClientModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                    'marketplace_id',
                    'name',
                    'country_code',
                    'endpoint',
                ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function newFactory()
    {
        return EndpointFactory::new();
    }
}
