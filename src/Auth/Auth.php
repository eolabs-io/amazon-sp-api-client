<?php

namespace EolabsIo\AmazonSpApiClient\Auth;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use EolabsIo\AmazonSpApiClient\Auth\Token;
use EolabsIo\AmazonSpApiClient\Models\Store;
use Illuminate\Http\Client\RequestException;

class Auth
{
    /** @var Store */
    private $store;

    /**
     * The cached Token instance.
     *
     * @var Token|null
     */
    protected $token;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function withStore(Store $store): self
    {
        $this->setStore($store);

        return $this;
    }

    private function setStore($store): self
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get the token URL.
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return 'https://api.amazon.com/auth/o2/token';
    }


    /**
     * Get the current token or new one.
     *
     * @return Token
     */
    public function token()
    {
        if (optional($this->token)->isNotExpired()) {
            return $this->token;
        }

        $accessTokenResponse = $this->getAccessTokenResponse();

        $this->token = Token::create($accessTokenResponse);

        return $this->token;
    }

    /**
     * Get the access token response.
     *
     * @return array
     */
    public function getAccessTokenResponse()
    {
        try {
            $response = Http::asForm()
                        ->post($this->getTokenUrl(), $this->getPostData())
                        ->throw();

            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            dd('getAccessTokenResponse()', $exception);
        }
    }

    /**
     * Get the body data for the token request.
     *
     * @return array
     */
    protected function getPostData(): array
    {
        $storeParams = Arr::only($this->store->toParameters(), [
            'refresh_token',
            'client_id',
            'client_secret',
        ]);

        return array_merge($storeParams, ['grant_type' => 'refresh_token']);
    }
}
