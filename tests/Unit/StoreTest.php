<?php

namespace EolabsIo\AmazonSpApiClient\Tests\Unit;

use EolabsIo\AmazonSpApiClient\Models\Participation;
use EolabsIo\AmazonSpApiClient\Models\Store;
use EolabsIo\AmazonSpApiClient\Tests\BaseModelTest;

class StoreTest extends BaseModelTest
{
    protected function getModelClass()
    {
        return Store::class;
    }

    /** @test */
    public function it_can_create_parameter_array()
    {
        $store = Store::factory()->create();

        $expectedParameters = [
            'client_id' => $store->client_id,
            'client_secret' => $store->client_secret,
            'refresh_token' => $store->refresh_token,
            'seller_id' => $store->seller_id,
        ];

        $this->assertArraysEqual($expectedParameters, $store->toParameters());
    }

    /** @test */
    public function it_has_marketplace_relationship()
    {
        $store = Store::factory()->create();
        $participations = Participation::factory()->times(3)->create(['seller_id' => $store->seller_id]);
        $marketplaces = $participations->load('marketplace')->pluck('marketplace');

        $this->assertArraysEqual($marketplaces->toArray(), $store->marketplaces->toArray());
    }
}
