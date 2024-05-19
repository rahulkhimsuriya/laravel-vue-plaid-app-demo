<?php

namespace App\Jobs;

use App\Models\BankAccount;
use App\Models\BankAccountTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Services\Plaid\Plaid;
use Services\Plaid\Transaction\DataTransferObjects\TransactionDTO;

class TransactionSyncJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public readonly Plaid $plaid;

    public function __construct(
        public readonly BankAccount $bankAccount,
    ) {
        $this->plaid = app('plaid');
    }

    public function handle()
    {
        $transactions = $this->transactions();
        $hasMore = true;
        $nextCursor = '';

        while ($hasMore) {
            $response = $this->plaid->transaction()->getSync([
                'access_token' => $this->bankAccount->access_token,
                'cursor' => $nextCursor,
                'count' => 500,
            ]);

            $hasMore = $response->hasMore;
            $nextCursor = $response->nextCursor;

            $now = Carbon::now()->toDateTimeString();

            collect($response->added)
                ->filter(function (TransactionDTO $transaction) {
                    return $transaction->accountId === $this->bankAccount->account_id;
                })
                ->filter(function (TransactionDTO $transaction) use ($transactions) {
                    return $transactions->where('transaction_id', '=', $transaction->transactionId)->count();
                })
                ->map(function (TransactionDTO $transaction) use ($now) {
                    return [
                        'bank_account_id' => $this->bankAccount->id,
                        'transaction_id' => $transaction->transactionId,
                        'merchant_name' => $transaction->merchantName ?? $transaction->name,
                        'merchant_logo_url' => $transaction->merchantLogoUrl,
                        'amount' => $transaction->amount,
                        'transaction_type' => $transaction->transactionType->value,
                        'payment_channel' => $transaction->paymentChannel->value,
                        'spent_at' => $transaction->datetime->toDateTimeString(),
                        'category' => $transaction->categories[0],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                })
                ->chunk(100)
                ->each(function ($transactions) {
                    $this->bankAccount->transactions()->createMany($transactions->toArray());
                });
        }
    }

    private function transactions(): EloquentCollection
    {
        return BankAccountTransaction::query()
            ->select(['id', 'transaction_id'])
            ->where('bank_account_id', '=', $this->bankAccount->id)
            ->get();
    }
}
