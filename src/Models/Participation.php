<?php

namespace EolabsIo\AmazonSpApiClient\Models;

use EolabsIo\AmazonSpApiClient\Models\Marketplace;
use EolabsIo\AmazonSpApiClient\Models\AmazonSpApiClientModel;
use EolabsIo\AmazonSpApiClient\Database\Factories\ParticipationFactory;

class Participation extends AmazonSpApiClientModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                            'marketplace_id',
                            'seller_id',
                            'has_seller_suspended_listings',
                        ];

    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class, 'marketplace_id', 'marketplace_id');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function newFactory()
    {
        return ParticipationFactory::new();
    }
}
