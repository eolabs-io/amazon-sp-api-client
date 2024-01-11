<?php

namespace EolabsIo\AmazonSpApiClient\Auth;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class Token
{
    /** @var string */
    private $accessToken;

    /** @var string */
    private $refreshToken;

    /** @var string */
    private $tokenType;

    /** @var int */
    private $expiresIn;

    /** @var Carbon */
    private $expireAt;

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = [];

    public function __construct(string $accessToken, string $refreshToken, string $tokenType, int $expiresIn)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;

        $this->expireAt = Carbon::now()->addSeconds($this->expiresIn);
    }

    public static function create(array $params): self
    {
        $accessToken = Arr::get($params, 'access_token');
        $refreshToken = Arr::get($params, 'refresh_token');
        $tokenType = Arr::get($params, 'token_type');
        $expiresIn = Arr::get($params, 'expires_in', -900);

        return new self($accessToken, $refreshToken, $tokenType, $expiresIn);
    }

    public function isExpired(): bool
    {
        return $this->expireAt->isPast();
    }

    public function isNotExpired(): bool
    {
        return ! $this->isExpired();
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}
