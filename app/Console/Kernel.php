<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

final class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // auth
        $schedule->command('auth:disabling-expired-codes')->everyMinute();
        $schedule->command('auth:clear-used-codes')->daily();

        // statistic
        $schedule->command('statistic:save-daily-wallet')->dailyAt('00:00');
        $schedule->command('statistic:create-monthly-report')->monthlyOn();
        $schedule->command('statistic:check-count-new-users')->everyTenMinutes();
        $schedule->command('statistic:save-daily-aum')->everyThirtyMinutes();

        // billing
        $schedule->command('billing:check-expired-replenishments')->everyMinute();
        $schedule->command('billing:calculate-trc-bonus')->dailyAt('00:01'); // 00:06
        $schedule->command('billing:bitcoin-lightning-withdrawal')->dailyAt('06:30'); // 00:05
        $schedule->command('billing:bitcoin-on-chain-withdrawal')->dailyAt('06:30'); // 00:06
        $schedule->command('billing:bitcoin-apollo-polygon-usdt-withdrawal')->dailyAt('06:30');

        //apollo
        $schedule->command('apollopayment:get-blockchain-address-id');
        $schedule->command('apollopayment:make-wallets-for-old-users');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
