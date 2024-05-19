<?php

namespace Services\Plaid\Transaction;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Services\Plaid\Account\DataTransferObjects\AccountDTO;
use Services\Plaid\PlaidService;
use Services\Plaid\Transaction\DataTransferObjects\TransactionDTO;
use Services\Plaid\Transaction\DataTransferObjects\TransactionSyncResponseDTO;
use Services\Plaid\Transaction\Enums\PaymentChannel;
use Services\Plaid\Transaction\Enums\TransactionType;

class Transaction extends PlaidService
{
    public function getSync(array $payload)
    {
        $response = Http::baseUrl($this->baseUrl())
            ->asJson()
            ->post(
                '/transactions/sync',
                array_merge(
                    $payload,
                    $this->credentials()
                )
            );

        if ($response->failed()) {
            return $response->throw();
        }

        $accounts = collect($response->json('accounts', []))->map(function ($account) {
            return new AccountDTO(
                accountId: $account['account_id'],
                mask: $account['mask'],
            );
        })->toArray();

        $added = collect($response->json('added'), [])->map(function ($transaction) {
            return new TransactionDTO(
                transactionId: $transaction['transaction_id'],
                accountId: $transaction['account_id'],
                amount: abs($transaction['amount']),
                transactionType: $transaction['amount'] > 0 ? TransactionType::CREDIT : TransactionType::DEBIT,
                paymentChannel: PaymentChannel::from(Str::snake($transaction['payment_channel'])),
                name: $transaction['name'],
                merchantName: $transaction['merchant_name'],
                merchantLogoUrl: $transaction['logo_url'],
                categories: $transaction['category'],
                datetime: Carbon::parse($transaction['datetime']),
            );
        })->toArray();

        return new TransactionSyncResponseDTO(
            hasMore: $response->json('has_more'),
            nextCursor: $response->json('next_cursor'),
            accounts: $accounts,
            added: $added,
        );
    }
}
