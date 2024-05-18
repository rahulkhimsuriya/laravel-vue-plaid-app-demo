<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Services\Plaid\Plaid;

class LinkTokenCreateController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var Plaid */
        $plaid = app('plaid');

        $linkToken = $plaid->linkToken()->create([
            'user' => [
                'client_user_id' => (string) Auth::id(),
            ],
            'client_name' => 'Personal Finance App',
            'transactions' => [
                'days_requested' => 730,
            ],
            'country_codes' => ['US'],
            'language' => 'en',
            'products' => ['transactions'],
            // 'webhook' => 'https://sample-web-hook.com',
            // 'redirect_uri' => 'https://domainname.com/oauth-page.html',
        ]);

        return response()->json([
            'data' => $linkToken->toArray(),
        ]);
    }
}
