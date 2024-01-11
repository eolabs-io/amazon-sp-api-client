<?php

namespace EolabsIo\AmazonSpApiClient\Database\Factories;

use EolabsIo\AmazonSpApiClient\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'seller_id' => $this->faker->text(14),
            'amazon_service_url' => $this->faker->url(), // 'https://sellingpartnerapi-na.amazon.com',
            'client_id' => $this->faker->text(14),
            'client_secret' => $this->faker->sha1(),
            'refresh_token' => $this->faker->text(14),
        ];
    }
}
