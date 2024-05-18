<?php

namespace Services\Plaid\LinkToken;

use Illuminate\Support\Facades\Http;
use Services\Plaid\LinkToken\DataTransferObjects\LinkTokenCreateResponseDTO;
use Services\Plaid\PlaidService;

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

        if ($response->failed()) {
            return $response->throw();
        }

        $response = $response->json();

        return new LinkTokenCreateResponseDTO(
            linkToken: $response['link_token'],
            expiration: $response['expiration'],
        );
    }
}
