<?php

namespace App\Enums;

enum BankAccountStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
}
