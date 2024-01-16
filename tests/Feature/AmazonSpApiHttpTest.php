<?php

namespace EolabsIo\AmazonSpApiClient\Tests;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use EolabsIo\AmazonSpApiClient\Models\Store;
use EolabsIo\AmazonSpApiClient\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use EolabsIo\AmazonSpApiClient\Models\Participation;
use EolabsIo\AmazonSpApiClient\Facades\AmazonSpApiHttp;
use EolabsIo\AmazonSpApiClient\Tests\Mocks\AuthRequestMock;

class AmazonSpApiHttpTest extends TestCase
{
    use RefreshDatabase;

    /** @var Store */
    private $store;

    /** @var Collection */
    private $marketplaces;


    public function setUp(): void
    {
        parent::setUp();

        $this->store = Store::factory()->create([
            'refresh_token' => 'Atzr|EXAMPLE+HOf9NtN2r1XqALt7fc9EL290cpEXBg',
            'client_id' => 'amzn1.application-oa2-client.EXAMPLE+HOf9NtN2r1XqALt7fc9EL290cpEXBg',
            'client_secret' => 'amzn1.oa2-cs.EXAMPLE+HOf9NtN2r1XqALt7fc9EL290cpEXBg',
            'amazon_service_url' => 'https://sellingpartnerapi-na.amazon.com',
        ]);

        AuthRequestMock::new()->fakeResponse();

        $participations = Participation::factory()->times(3)
                            ->create(['seller_id' => $this->store->seller_id]);

        $this->marketplaces = $participations->load('marketplace')->pluck('marketplace');

        AmazonSpApiHttp::partialMock()
            ->shouldReceive('getAccessToken')
            ->andReturn('Atza|EXAMPLE--d2FsbWFydEFwaS1jbGllbnQtaWQ6d2FsbWFydEFwaS1jbGllbnQtc2VjcmV0');
    }

    /** @test */
    public function it_can_make_a_endpoint_request()
    {
        Http::fake();

        $parameters = ['param_1' => '12345'];
        $endpoint = 'someEndpoint/version';

        $response = AmazonSpApiHttp::withStore($this->store)->get($endpoint, $parameters);

        Http::assertSent(function ($request) {
            return $request->hasHeader('x-amz-access-token', 'Atza|EXAMPLE--d2FsbWFydEFwaS1jbGllbnQtaWQ6d2FsbWFydEFwaS1jbGllbnQtc2VjcmV0') &&
                $request->hasHeader('User-Agent', 'eoLabs Amazon SP-API Client/1.0.0') &&
                $request->hasHeader('Accept', 'application/json') &&
                $request->url() == 'https://sellingpartnerapi-na.amazon.com/someEndpoint/version?param_1=12345';
        });
    }

    /** @test */
    public function it_can_get_marketplace_ids()
    {
        Http::fake();

        $registeredMarketplaceIds = AmazonSpApiHttp::withStore($this->store)->getRegisteredMarketplaceIds();

        $this->assertArraysEqual(
            $registeredMarketplaceIds,
            $this->marketplaces->pluck('marketplace_id')->values()->toArray()
        );
    }

    /** @test */
    public function it_fails_to_get_marketplace_ids()
    {
        Http::fake();

        DB::table('marketplaces')->delete();

        $registeredMarketplaceIds = AmazonSpApiHttp::withStore($this->store)->getRegisteredMarketplaceIds();

        $this->assertEquals($registeredMarketplaceIds, []);
    }

    // Helpers //
    private function assertArraysEqual($array1, $array2)
    {
        $sortedArray1 = Arr::sortRecursive($array1);
        $sortedArray2 = Arr::sortRecursive($array2);

        // return
        $this->assertEquals($sortedArray1, $sortedArray2);
    }
}
