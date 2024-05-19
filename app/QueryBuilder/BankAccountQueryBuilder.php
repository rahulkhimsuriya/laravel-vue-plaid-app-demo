<?php

namespace App\QueryBuilder;

use App\Enums\BankAccountStatus;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Carbon;

class BankAccountQueryBuilder extends EloquentBuilder
{
    public function active()
    {
        return $this
            ->where(function (EloquentBuilder $query) {
                return $query
                    ->where('status', '=', BankAccountStatus::ACTIVE)
                    ->orWhere(function (EloquentBuilder $query) {
                        return $query
                            ->where('status', '!=', BankAccountStatus::EXPIRED)
                            ->where('access_token_expired_at', '>', Carbon::now()->toDateTimeString());
                    });
            });
    }

    public function expired()
    {
        return $this
            ->where(function (EloquentBuilder $query) {
                return $query
                    ->where('status', '=', BankAccountStatus::EXPIRED)
                    ->where('access_token_expired_at', '<=', Carbon::now()->toDateTimeString());
            });
    }
}
