<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Statistic;

use App\Models\Billing\Wallet;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Dto\Models\Billing\WalletDto;
use App\Dto\Models\Statistic\DailyWalletDto;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Statistic\DailyWalletService;

final class SaveDailyWalletCommand extends Command
{
    private const COUNT = 300;

    protected $signature = 'statistic:save-daily-wallet';

    protected $description = 'Сохраняем баланс кошельков пользователей на конец дня';

    public function handle(
        WalletService      $walletService,
        DailyWalletService $dailyWalletService,
    ): void
    {
        $today = Carbon::now()->toDateString();

        $callback = function (Collection $items) use ($dailyWalletService, $today) {
            $items->map(function (Wallet $item) use ($dailyWalletService, $today) {
                $wallet = WalletDto::fromArray($item->toArray());

                if (env('DEMO_ACCOUNT_UUID') === $wallet->getAccountUuid()) {
                    return;
                }

                $dailyWalletService->create(DailyWalletDto::fromArray([
                    'account_uuid' => $wallet->getAccountUuid(),
                    'type' => $wallet->getType(),
                    'amount' => $wallet->getAmount(),
                    'created_at' => $today,
                ]));
            });
        };

        $walletService->allByFiltersWithChunk([], self::COUNT, $callback);
    }
}
