<?php

namespace Services\Plaid;

use Illuminate\Support\ServiceProvider;

class PlaidServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('plaid', function () {
            return new Plaid;
        });
    }
}
