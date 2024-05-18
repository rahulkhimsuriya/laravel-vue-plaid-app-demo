<?php

namespace App\Http\Controllers;

use App\Enums\BankAccountStatus;
use App\Events\BankAccountLinked;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Services\Plaid\Plaid;

class PublicTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'public_token' => ['required', 'string'],
        ]);

        /** @var Plaid */
        $plaid = app('plaid');

        $response = $plaid->item()->publicTokenExchange($request->get('public_token'));

        $bankAccount = BankAccount::create([
            'user_id' => Auth::id(),
            'item_id' => $response->itemId,
            'access_token' => $response->accessToken,
            'access_token_expired_at' => Carbon::now()->addDays(90),
            'status' => BankAccountStatus::PENDING,
        ]);

        BankAccountLinked::dispatch($bankAccount);

        return redirect(route('dashboard'));
    }
}
