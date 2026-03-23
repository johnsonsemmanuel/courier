<?php

namespace App\Providers;

use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
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
        // HTTPS: certificate is installed in hosting (cPanel); align Laravel URLs & cookies.
        if (config('app.force_https') || str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        // Welcome email with account details only after email is verified
        Event::listen(Verified::class, function (Verified $event): void {
            $user = $event->user;
            $account = $user->accounts()->first();
            if ($account) {
                try {
                    $user->notify(new WelcomeNotification($user, $account));
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        });

        Gate::policy(Beneficiary::class, BeneficiaryPolicy::class);
        Gate::policy(BillPayee::class, BillPayeePolicy::class);
        Gate::policy(BillPayment::class, BillPaymentPolicy::class);
        Gate::policy(\App\Models\Card::class, \App\Policies\CardPolicy::class);
    }
}
