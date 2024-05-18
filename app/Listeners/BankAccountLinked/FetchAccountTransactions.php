<?php

namespace App\Listeners\BankAccountLinked;

use App\Events\BankAccountLinked;

class FetchAccountTransactions
{
    public function __construct()
    {
    }

    public function handle(BankAccountLinked $event): void
    {
        //
    }
}
