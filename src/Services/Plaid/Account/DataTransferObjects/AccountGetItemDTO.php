<?php

namespace Services\Plaid\Account\DataTransferObjects;

class AccountGetItemDTO
{
    public function __construct(
        public readonly string $itemId,
        public readonly string $institutionId
    ) {
    }

    /**
     * Api response
     */
    public function toArray(): array
    {
        return [
            'item_id' => $this->itemId,
            'institution_id' => $this->institutionId,
        ];
    }
}
