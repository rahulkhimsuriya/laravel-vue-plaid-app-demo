<?php

namespace Services\Plaid\Account\DataTransferObjects;

class AccountDTO
{
    public function __construct(
        public readonly string $accountId,
        public readonly string $mask
    ) {
    }

    /**
     * Api response
     */
    public function toArray(): array
    {
        return [
            'account_id' => $this->accountId,
            'mask' => $this->mask,
        ];
    }
}
