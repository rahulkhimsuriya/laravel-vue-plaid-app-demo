<?php

namespace Services\Plaid\Transaction\DataTransferObjects;

use Services\Plaid\Account\DataTransferObjects\AccountDTO;

/**
 * @property-read AccountDTO[] accounts
 * @property-read TransactionDTO[] added
 */
readonly class TransactionSyncResponseDTO
{
    public function __construct(
        public bool $hasMore,
        public bool $nextCursor,
        public array $accounts,
        public array $added,
    ) {
    }

    /**
     * Api response
     */
    public function toArray(): array
    {
        return [
            'accounts' => $this->accounts,
            'added' => $this->added,
            'has_more' => $this->hasMore,
            'next_cursor' => $this->nextCursor,
        ];
    }
}
