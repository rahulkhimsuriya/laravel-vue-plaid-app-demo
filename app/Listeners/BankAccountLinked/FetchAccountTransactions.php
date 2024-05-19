<?php

namespace App\Listeners\BankAccountLinked;

use App\Events\BankAccountLinked;
use App\Jobs\TransactionSyncJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class FetchAccountTransactions implements ShouldQueue
{
    public function handle(BankAccountLinked $event): void
    {
        TransactionSyncJob::dispatch($event->bankAccount)->delay(now()->addMinutes(5));
    }
}
