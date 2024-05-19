<?php

use App\Http\Controllers\PlaidWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/plaid', PlaidWebhookController::class);
