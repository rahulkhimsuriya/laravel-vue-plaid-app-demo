<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Services\Plaid\Institution\DataTransferObjects\InstitutionResponseDTO;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Plaid */
        $plaid = app('plaid');

        $banks = $plaid->institution()->getAll([
            'country_codes' => ['US'],
            'count' => 500,
            'offset' => 0,
        ]);

        $now = now();

        collect($banks)
            ->map(function (InstitutionResponseDTO $bank) use ($now) {
                return [
                    ...$bank->toArray(),
                    'country_codes' => json_encode($bank->countryCodes),
                    'id' => Str::ulid(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })
            ->chunk(100)
            ->each(function ($banks) {
                Bank::insert($banks->toArray());
            });
    }
}
