<?php

namespace EolabsIo\AmazonSpApiClient;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use EolabsIo\AmazonSpApiClient\Facades\Auth;
use EolabsIo\AmazonSpApiClient\Models\Store;

class AmazonSpApiHttp
{
    /** @var Store */
    private $store;


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

    public function get(string $endpoint, array $parameters)
    {
        $url = $this->getFullyQualifiedUrl($endpoint);
        $headers = $this->getHeaders();

        return Http::withHeaders($headers)->get($url, $parameters);
    }

    public function getFullyQualifiedUrl(string $endpoint): string
    {
        $baseUri = $this->getBaseUri();
        $endpoint = Str::start($endpoint, '/');

        return $baseUri . $endpoint;
    }

    public function getBaseUri(): string
    {
        return $this->store->amazon_service_url;
    }

    private function getHeaders(): array
    {
        return ['x-amz-access-token' => $this->getAccessToken()];
    }

    public function getAccessToken(): string
    {
        $token = Auth::withStore($this->store)->token();
        return $token->accessToken;
    }

    public function getRegisteredMarketplaceIds(): array
    {
        return $this->store->marketplaces->pluck('marketplace_id')->toArray();
    }

}
