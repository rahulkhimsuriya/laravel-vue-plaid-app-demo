<?php

namespace Services\Plaid\Institution;

use Illuminate\Support\Facades\Http;
use Services\Plaid\Institution\DataTransferObjects\InstitutionResponseDTO;
use Services\Plaid\PlaidService;

class Institution extends PlaidService
{
    public function getAll(array $payload)
    {
        $response = Http::baseUrl($this->baseUrl())
            ->asJson()
            ->post(
                '/institutions/get',
                array_merge(
                    $payload,
                    $this->credentials()
                )
            );

        if ($response->failed()) {
            return $response->throw();
        }

        return collect($response->json('institutions'))
            ->map(function ($institution) {
                return new InstitutionResponseDTO(
                    name: $institution['name'],
                    institutionId: $institution['institution_id'],
                    countryCodes: $institution['country_codes'],
                );
            })
            ->toArray();
    }
}
