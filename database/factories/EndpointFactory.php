<?php

namespace EolabsIo\AmazonSpApiClient\Database\Factories;

use EolabsIo\AmazonSpApiClient\Models\Endpoint;
use Illuminate\Database\Eloquent\Factories\Factory;

class EndpointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Endpoint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(14),
            'country_code' => $this->faker->unique()->countryCode(),
            'endpoint' => $this->faker->url(), // 'https://mws.amazonservices.com/',
            'marketplace_id' => $this->faker->text(14),
        ];
    }
}
