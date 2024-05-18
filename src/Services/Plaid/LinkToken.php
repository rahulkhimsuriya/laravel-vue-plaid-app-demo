<?php

namespace Services\Plaid;

use Illuminate\Support\Facades\Http;

class LinkToken extends PlaidService
{
    public function create(array $payload)
    {
        $response = Http::baseUrl($this->baseUrl())
            ->asJson()
            ->post(
                '/link/token/create',
                array_merge($payload, $this->credentials())
            );

        dd($response->json());
    }
}
