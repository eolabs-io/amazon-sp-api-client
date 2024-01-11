<?php

namespace EolabsIo\AmazonSpApiClient\Database\Factories;

use EolabsIo\AmazonSpApiClient\Models\Store;
use EolabsIo\AmazonSpApiClient\Models\Marketplace;
use EolabsIo\AmazonSpApiClient\Models\Participation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Participation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'marketplace_id' => Marketplace::factory()->create()->marketplace_id,
            'seller_id' => Store::factory()->create()->seller_id,
            'has_seller_suspended_listings' => $this->faker->randomElement(['No', 'Restricted']),
        ];
    }
}
