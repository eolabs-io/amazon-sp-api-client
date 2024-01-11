<?php

namespace EolabsIo\AmazonSpApiClient\Tests\Unit;

use EolabsIo\AmazonSpApiClient\Models\Marketplace;
use EolabsIo\AmazonSpApiClient\Tests\BaseModelTest;
use EolabsIo\AmazonSpApiClient\Database\Seeders\EndpointSeeder;

class MarketplaceTest extends BaseModelTest
{
    protected function getModelClass()
    {
        return Marketplace::class;
    }

    /** @test */
    public function it_can_create_parameter_array()
    {
        $this->seed(EndpointSeeder::class);
        $marketplace = Marketplace::factory()->create();

        $expectedParameters = [
            'endpoint' => $marketplace->mwsEndpoint->endpoint,
            'marketplace_id' => $marketplace->marketplace_id,
        ];

        $this->assertArraysEqual($expectedParameters, $marketplace->toParameters());
    }
}
