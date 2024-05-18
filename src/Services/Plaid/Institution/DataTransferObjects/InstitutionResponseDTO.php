<?php

namespace Services\Plaid\Institution\DataTransferObjects;

class InstitutionResponseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $institutionId,
        public readonly array $countryCodes
    ) {
    }

    /**
     * Api response
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'institution_id' => $this->institutionId,
            'country_codes' => $this->countryCodes,
        ];
    }
}
