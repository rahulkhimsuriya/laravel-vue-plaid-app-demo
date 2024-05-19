<?php

namespace App\Models;

use App\Enums\BankAccountStatus;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property CarbonImmutable access_token_expired_at
 * @property BankAccountStatus status
 */
class BankAccount extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'access_token_expired_at' => 'immutable_datetime',
        'status' => BankAccountStatus::class,
    ];

    public function isPending()
    {
        return $this->status === BankAccountStatus::PENDING;
    }

    public function isActive()
    {
        return $this->status === BankAccountStatus::ACTIVE;
    }

    public function isExpired()
    {
        if ($this->status === BankAccountStatus::ACTIVE) {
            return true;
        }

        if ($this->access_token_expired_at->isPast()) {
            return true;
        }

        return false;
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(BankAccountTransaction::class, 'bank_account_id');
    }
}
