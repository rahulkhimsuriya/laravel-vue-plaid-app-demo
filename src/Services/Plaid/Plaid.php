<?php

namespace Services\Plaid;

class Plaid
{
    public function linkToken(): LinkToken
    {
        return new LinkToken();
    }
}
