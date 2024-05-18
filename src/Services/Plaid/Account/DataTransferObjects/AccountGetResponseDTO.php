<?php

namespace Services\Plaid\Account\DataTransferObjects;

class AccountGetResponseDTO
{
    public function __construct(
        public readonly AccountGetItemDTO $item,
        public readonly AccountDTO $account
    ) {
    }

    /**
     * Api response
     */
    public function toArray(): array
    {
        return [
            'item' => $this->item->toArray(),
            'account' => $this->account->toArray(),
        ];
    }
}
