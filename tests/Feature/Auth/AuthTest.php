<?php

namespace EolabsIo\AmazonSpApiClient\Tests\Feature\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use EolabsIo\AmazonSpApiClient\Auth\Token;

use EolabsIo\AmazonSpApiClient\Facades\Auth;
use EolabsIo\AmazonSpApiClient\Models\Store;
use EolabsIo\AmazonSpApiClient\Tests\TestCase;
use EolabsIo\AmazonSpApiClient\Tests\Mocks\AuthRequestMock;

class AuthTest extends TestCase
{
    /** @var Store */
    public $store;

    /** @var Token */
    public $token;

    /** @var Carbon */
    public $knownDate;

    /** @var array */
    public $expected;


    public function setUp(): void
    {
        parent::setUp();

        $this->store = Store::factory()->create();

        $this->knownDate = Carbon::parse(1560972198000);
        Carbon::setTestNow($this->knownDate);

        AuthRequestMock::new()->fakeResponse();

        $this->expected = $this->getExpectedResults();

        $this->token = $this->getToken($this->store);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        Carbon::setTestNow();
    }

    /** @test */
    public function it_sends_the_correct_request_query()
    {
        $store = $this->store;

        // Request for Token
        Http::assertSent(function ($request) use ($store) {
            return $request->hasHeader('Content-Type', 'application/x-www-form-urlencoded') &&
                   $request->url() == 'https://api.amazon.com/auth/o2/token' &&
                   $request['grant_type'] == 'refresh_token' &&
                   $request['refresh_token'] == $store->refresh_token &&
                   $request['client_id'] == $store->client_id &&
                   $request['client_secret'] == $store->client_secret;
        });

    }

    /** @test */
    public function it_can_get_a_valid_token()
    {
        // Token
        $this->assertEquals($this->expected['accessToken'], $this->token->accessToken);
        $this->assertEquals($this->expected['refreshToken'], $this->token->refreshToken);
        $this->assertEquals('bearer', $this->token->tokenType);
        $this->assertEquals(3600, $this->token->expiresIn);
        $this->assertFalse($this->token->isExpired());

        // TokenDetail
        $this->assertEquals('Tue Mar 29 2005 21:20:00 GMT+0000', $this->token->expireAt->toString());
    }

    /** @test */
    public function it_can_get_a_new_token_after_expiration()
    {
        // Token
        $this->assertEquals($this->expected['accessToken'], $this->token->accessToken);
        $this->assertEquals($this->expected['refreshToken'], $this->token->refreshToken);
        $this->assertEquals('bearer', $this->token->tokenType);
        $this->assertEquals(3600, $this->token->expiresIn);
        $this->assertFalse($this->token->isExpired());

        // Set current time to now
        Carbon::setTestNow();
        $this->assertTrue($this->token->isExpired());
        $this->token = $this->getToken($this->store);

        $this->assertEquals($this->expected['accessToken2'], $this->token->accessToken);
        $this->assertEquals($this->expected['refreshToken2'], $this->token->refreshToken);
    }

    private function getToken(Store $store = null): Token
    {
        $store = $store ?? Store::factory()->create();
        return Auth::withStore($store)->token();
    }

    private function getExpectedResults(): array
    {
        return [
            'accessToken' => 'Atza|EXAMPLE--d2FsbWFydEFwaS1jbGllbnQtaWQ6d2FsbWFydEFwaS1jbGllbnQtc2VjcmV0',
            'refreshToken' => 'Atzr|EXAMPLE--IFmmP2wXQnYlDNlRqbHDYqK2aLHPKwhKbU3RDokD_JbQZe10tabGZ',
            'accessToken2' => 'Atza|EXAMPLE--CDvYdkXpMojYCCtcm54Ugvm9MMW-7HZFS-zlJ15buEIMpXjn6S5aETwzVx',
            'refreshToken2' => 'Atzr|EXAMPLE--d4GLnj5LjIUJ551wJQFthefOY8ypVlrF1S1PBgdGf368NGL-P92LqXmCIY',
        ];
    }
}
