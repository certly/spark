<?php

namespace Laravel\Spark\Providers;

use Laravel\Spark\Spark;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Automatically support two-factor authentication.
     *
     * @var bool
     */
    protected $twoFactorAuth = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (method_exists($this, 'customizeSpark')) {
            $this->customizeSpark();
        }

        if (method_exists($this, 'customizeRegistration')) {
            $this->customizeRegistration();
        }

        if (method_exists($this, 'customizeRoles')) {
            $this->customizeRoles();
        }

        if (method_exists($this, 'customizeProfileUpdates')) {
            $this->customizeProfileUpdates();
        }

        if (method_exists($this, 'customizeSubscriptionPlans')) {
            $this->customizeSubscriptionPlans();
        }

        if (method_exists($this, 'customizeSettingsTabs')) {
            $this->customizeSettingsTabs();
        }

        if ($this->twoFactorAuth) {
            Spark::withTwoFactorAuth();
        }

        Spark::generateInvoicesWith($this->invoiceWith);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
