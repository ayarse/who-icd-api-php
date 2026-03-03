<?php

declare(strict_types=1);

namespace WhoIcd;

use Saloon\Http\Connector;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Response;
use WhoIcd\Resources\FoundationResource;
use WhoIcd\Resources\LinearizationResource;
use WhoIcd\Resources\Icd10Resource;

class WhoIcdConnector extends Connector
{
    private ?string $accessToken = null;

    private ?int $tokenExpiresAt = null;

    public function __construct(
        protected readonly string $clientId,
        protected readonly string $clientSecret,
        protected readonly string $apiVersion = 'v2',
        protected readonly string $language = 'en',
        protected readonly string $tokenEndpoint = 'https://icdaccessmanagement.who.int/connect/token',
        protected readonly string $baseUrl = 'https://id.who.int',
    ) {}

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Accept-Language' => $this->language,
            'API-Version' => $this->apiVersion,
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        $this->ensureAccessToken();

        return new TokenAuthenticator($this->accessToken);
    }

    protected function ensureAccessToken(): void
    {
        if ($this->accessToken && $this->tokenExpiresAt && time() < $this->tokenExpiresAt) {
            return;
        }

        $ch = curl_init($this->tokenEndpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
                'scope' => 'icdapi_access',
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || $response === false) {
            throw new \RuntimeException('Failed to obtain WHO ICD API access token. HTTP ' . $httpCode);
        }

        $data = json_decode($response, true);

        $this->accessToken = $data['access_token'] ?? throw new \RuntimeException('No access_token in token response');
        $this->tokenExpiresAt = time() + ($data['expires_in'] ?? 3600) - 60;
    }

    /**
     * Set an access token directly (useful for testing or pre-obtained tokens).
     */
    public function setAccessToken(string $token, ?int $expiresAt = null): static
    {
        $this->accessToken = $token;
        $this->tokenExpiresAt = $expiresAt ?? time() + 3600;

        return $this;
    }

    public function foundation(): FoundationResource
    {
        return new FoundationResource($this);
    }

    public function linearization(): LinearizationResource
    {
        return new LinearizationResource($this);
    }

    public function icd10(): Icd10Resource
    {
        return new Icd10Resource($this);
    }
}
