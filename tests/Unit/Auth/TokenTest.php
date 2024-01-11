<?php
namespace EolabsIo\AmazonSpApiClient\Tests\Unit\Auth;

use EolabsIo\AmazonSpApiClient\Auth\Token;
use EolabsIo\AmazonSpApiClient\Tests\TestCase;

class TokenTest extends TestCase
{
    public $token;


    public function setUp(): void
    {
        parent::setUp();

        $this->token = Token::create([
            'access_token' => 'Atza|EXAMPLE--9eomyHRl2oSsFULKgv3kKeFQgqd8W',
            "refresh_token" => "Atzr|EXAMPLE--wXQnYlDNlRqbHDYqU3RDokD_JbQZ",
            'token_type' => 'bearer',
            'expires_in' => 3600
            ]);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->token = null;
    }

    /** @test */
    public function it_can_create_token()
    {
        $this->assertEquals('Atza|EXAMPLE--9eomyHRl2oSsFULKgv3kKeFQgqd8W', $this->token->accessToken);
        $this->assertEquals('Atzr|EXAMPLE--wXQnYlDNlRqbHDYqU3RDokD_JbQZ', $this->token->refreshToken);
        $this->assertEquals('bearer', $this->token->tokenType);
        $this->assertEquals(3600, $this->token->expiresIn);

        $this->assertFalse($this->token->isExpired());
    }

    /** @test */
    public function it_can_expire_token()
    {
        $this->assertFalse($this->token->isExpired());

        $this->travel(3601)->seconds();

        $this->assertTrue($this->token->isExpired());
    }
}
