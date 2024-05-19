<?php

namespace Services\Plaid\Transaction\Enums;

enum TransactionType: string
{
    case DEBIT = 'debit';
    case CREDIT = 'credit';
}
