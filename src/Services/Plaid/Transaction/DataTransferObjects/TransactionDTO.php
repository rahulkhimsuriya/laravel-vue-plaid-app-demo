<?php

namespace Services\Plaid\Transaction\DataTransferObjects;

use Illuminate\Support\Carbon;
use Services\Plaid\Transaction\Enums\PaymentChannel;
use Services\Plaid\Transaction\Enums\TransactionType;

readonly class TransactionDTO
{
    public function __construct(
        public string $transactionId,
        public string $accountId,
        public int $amount,
        public TransactionType $transactionType,
        public PaymentChannel $paymentChannel,
        public string $name,
        public ?string $merchantName,
        public ?string $merchantLogoUrl,
        public array $categories,
        public Carbon $datetime,
    ) {
    }

    /**
     * Api response
     */
    public function toArray(): array
    {
        return [
            'transaction_id' => $this->transactionId,
            'account_id' => $this->accountId,
            'name' => $this->name,
            'merchant_name' => $this->merchantName,
            'merchant_logo_url' => $this->merchantLogoUrl,
            'amount' => $this->amount,
            'transaction_type' => $this->transactionType->value,
            'payment_channel' => $this->paymentChannel->value,
            'datetime' => $this->datetime->toDateTimeString(),
            'categories' => $this->categories,
        ];
    }
}
