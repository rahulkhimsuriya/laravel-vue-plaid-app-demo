<?php

namespace Services\Plaid;

use Services\Plaid\Account\Account;
use Services\Plaid\Institution\Institution;
use Services\Plaid\Item\Item;
use Services\Plaid\LinkToken\LinkToken;
use Services\Plaid\Transaction\Transaction;

class Plaid
{
    public function account(): Account
    {
        return new Account();
    }

    public function item(): Item
    {
        return new Item();
    }

    public function institution(): Institution
    {
        return new Institution();
    }

    public function linkToken(): LinkToken
    {
        return new LinkToken();
    }

    public function transaction(): Transaction
    {
        return new Transaction();
    }
}
