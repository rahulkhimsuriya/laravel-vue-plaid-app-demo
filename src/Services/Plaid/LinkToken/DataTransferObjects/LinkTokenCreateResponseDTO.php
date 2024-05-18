<?php

namespace Services\Plaid\LinkToken\DataTransferObjects;

class LinkTokenCreateResponseDTO
{
    public function __construct(
        public readonly string $linkToken,
        public readonly string $expiration
    ) {
    }

    /**
     * Api response
     */
    public function toArray(): array
    {
        return [
            'link_token' => $this->linkToken,
            'expiration' => $this->expiration,
        ];
    }
}
