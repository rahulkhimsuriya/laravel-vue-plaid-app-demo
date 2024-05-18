<?php

namespace Services\Plaid\Item;

use Illuminate\Support\Facades\Http;
use Services\Plaid\Item\DataTransferObjects\ItemPublicTokenExchangeResponseDTO;
use Services\Plaid\PlaidService;

class Item extends PlaidService
{
    public function publicTokenExchange(string $publicToken)
    {
        $response = Http::baseUrl($this->baseUrl())
            ->asJson()
            ->post(
                '/item/public_token/exchange',
                array_merge(
                    ['public_token' => $publicToken],
                    $this->credentials()
                )
            );

        if ($response->failed()) {
            return $response->throw();
        }

        $response = $response->json();

        return new ItemPublicTokenExchangeResponseDTO(
            accessToken: $response['access_token'],
            itemId: $response['item_id'],
        );
    }
}
