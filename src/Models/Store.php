<?php

namespace EolabsIo\AmazonSpApiClient\Models;

use EolabsIo\AmazonSpApiClient\Models\Marketplace;
use EolabsIo\AmazonSpApiClient\Models\Participation;
use EolabsIo\AmazonSpApiClient\Models\AmazonSpApiClientModel;
use EolabsIo\AmazonSpApiClient\Models\Contracts\Parameterable;
use EolabsIo\AmazonSpApiClient\Database\Factories\StoreFactory;

class Store extends AmazonSpApiClientModel implements Parameterable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                    'seller_id',
                    'amazon_service_url',
                    'client_id',
                    'client_secret',
                    'refresh_token',
                ];


    public function marketplaces()
    {
        return $this->hasManyThrough(
            Marketplace::class,
            Participation::class,
            'seller_id',
            'marketplace_id',
            'seller_id',
            'marketplace_id'
        );
    }

    public function toParameters(): array
    {
        return [
            'refresh_token' => $this->refresh_token,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'seller_id' => $this->seller_id,
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function newFactory()
    {
        return StoreFactory::new();
    }
}
