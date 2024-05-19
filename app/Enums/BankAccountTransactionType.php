<?php

namespace App\Enums;

enum BankAccountTransactionType: string
{
    case DEBIT = 'debit';
    case CREDIT = 'credit';
}
