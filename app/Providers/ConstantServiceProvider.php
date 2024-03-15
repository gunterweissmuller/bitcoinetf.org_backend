<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConstantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        define('PAP_SALE_TRACKER_HOST', 'https://bitcoinetf.postaffiliatepro.com/scripts/sale.php');
        define('PAP_ACCOUNT_ID', 'bitcoinetf.postaffiliatepro.com');
        define('METAMASK_MSG', 'I fully understand and agree to the Terms and Conditions (available at https://bitcoinetf.org/terms) and certify that I am not a US citizen, resident or taxpayer.');
    }
}
