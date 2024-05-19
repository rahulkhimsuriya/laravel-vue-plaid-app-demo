<?php

namespace Services\Plaid\Transaction\Enums;

enum PaymentChannel: string
{
    case ONLINE = 'online';
    case IN_STORE = 'in_store';
    case OTHER = 'other';
}
