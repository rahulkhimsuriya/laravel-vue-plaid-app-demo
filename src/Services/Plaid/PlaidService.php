<?php

namespace Services\Plaid;

use Exception;

abstract class PlaidService
{
    private readonly string $environment;

    private readonly string $clientId;

    private readonly string $clientSecret;

    public function __construct()
    {
        $this->environment = config('services.plaid.environment');
        $this->clientId = config('services.plaid.client_id');
        $this->clientSecret = config('services.plaid.client_secret');
    }

    protected function baseUrl(): string|Exception
    {
        return match ($this->environment) {
            'sandbox' => 'https://sandbox.plaid.com',
            'production' => 'https://production.plaid.com',
            'development' => 'https://development.plaid.com',
            'default' => throw new Exception('Plaid unknown environment provided.')
        };
    }

    protected function environment(): string
    {
        return $this->environment;
    }

    protected function clientId(): string
    {
        return $this->clientId;
    }

    protected function clientSecret(): string
    {
        return $this->clientSecret;
    }

    protected function credentials(): array
    {
        return [
            'client_id' => $this->clientId(),
            'secret' => $this->clientSecret(),
        ];
    }
}
