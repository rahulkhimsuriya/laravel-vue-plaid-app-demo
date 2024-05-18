<?php

namespace App\Http\Controllers;

use App\Events\BankAccountLinked;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Dashboard');
    }
}
