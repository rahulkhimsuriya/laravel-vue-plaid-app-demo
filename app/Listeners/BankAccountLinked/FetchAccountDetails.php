<?php

namespace App\Listeners\BankAccountLinked;

use App\Enums\BankAccountStatus;
use App\Events\BankAccountLinked;
use App\Models\Bank;
use Illuminate\Contracts\Queue\ShouldQueue;
use Services\Plaid\Plaid;

class FetchAccountDetails implements ShouldQueue
{
    public readonly Plaid $plaid;

    public function __construct()
    {
        $this->plaid = app('plaid');
    }

    public function handle(BankAccountLinked $event): void
    {
        if (!$event->bankAccount->isPending()) {
            return;
        }

        $response = $this->plaid->account()->get($event->bankAccount->access_token);

        $bank = Bank::getByInstitutionId($response->item->institutionId);

        $event->bankAccount->update([
            'bank_id' => $bank->id,
            'account_id' => $response->account->accountId,
            'mask' => $response->account->mask,
            'status' => BankAccountStatus::ACTIVE,
        ]);
    }
}
