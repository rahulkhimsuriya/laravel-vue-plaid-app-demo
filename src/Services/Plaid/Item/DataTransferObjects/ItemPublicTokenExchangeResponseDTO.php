<?php

namespace Services\Plaid\Item\DataTransferObjects;

class ItemPublicTokenExchangeResponseDTO
{
    public function __construct(
        public readonly string $accessToken,
        public readonly string $itemId
    ) {
    }

    /**
     * Api response
     */
    public function toArray(): array
    {
        return [
            'access_token' => $this->accessToken,
            'item_id' => $this->itemId,
        ];
    }
}
