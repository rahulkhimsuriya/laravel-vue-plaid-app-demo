<?php

namespace Services\Plaid\Account;

use Illuminate\Support\Facades\Http;
use Services\Plaid\Account\DataTransferObjects\AccountDTO;
use Services\Plaid\Account\DataTransferObjects\AccountGetItemDTO;
use Services\Plaid\Account\DataTransferObjects\AccountGetResponseDTO;
use Services\Plaid\PlaidService;

class Account extends PlaidService
{
    public function get(string $accessToken)
    {
        $response = Http::baseUrl($this->baseUrl())
            ->asJson()
            ->post(
                '/accounts/get',
                array_merge(
                    ['access_token' => $accessToken],
                    $this->credentials()
                )
            );

        if ($response->failed()) {
            return $response->throw();
        }

        $account = $response->json('accounts.0');
        $item = $response->json('item');

        return new AccountGetResponseDTO(
            item: new AccountGetItemDTO(
                itemId: $item['item_id'],
                institutionId: $item['institution_id'],
            ),
            account: new AccountDTO(
                accountId: $account['account_id'],
                mask: $account['mask'],
            )
        );
    }
}
