<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var User */
        $authUser = Auth::user();

        return Inertia::render('Dashboard', [
            'transactions' => $authUser->transactions()
                ->with(['bankAccount.bank'])
                ->paginate(10)
                ->onEachSide(2)
                ->withQueryString(),
        ]);
    }
}
