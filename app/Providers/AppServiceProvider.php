<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\Beneficiary;
use App\Models\BillPayee;
use App\Models\BillPayment;
use App\Policies\BeneficiaryPolicy;
use App\Policies\BillPayeePolicy;
use App\Policies\BillPaymentPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS only when explicitly enabled by environment config.
        if (config('app.force_https')) {
            URL::forceScheme('https');
        }

        Gate::policy(Beneficiary::class, BeneficiaryPolicy::class);
        Gate::policy(BillPayee::class, BillPayeePolicy::class);
        Gate::policy(BillPayment::class, BillPaymentPolicy::class);
        Gate::policy(\App\Models\Card::class, \App\Policies\CardPolicy::class);
    }
}
