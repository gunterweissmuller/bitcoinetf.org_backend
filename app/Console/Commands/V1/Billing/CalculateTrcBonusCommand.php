<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Billing;

use App\Enums\Settings\Global\SymbolEnum;
use App\Services\Api\V1\Settings\GlobalService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

final class CalculateTrcBonusCommand extends Command
{
    protected $signature = 'billing:calculate-trc-bonus';

    protected $description = 'Автоматическая снижение процента бонуса';

    public function handle(
        GlobalService $globalService,
    ): void {
        $trcBonusDecrease = $globalService->getTrcBonusDecrease();

        if (Carbon::now()->diffInDays(Carbon::parse($trcBonusDecrease)) == 0) {
            $trcBonus = (float)number_format($globalService->getTrcBonus(), 8, '.', '');

            if ($trcBonus > 0) {
                $globalService->update([
                    'symbol' => SymbolEnum::TRC_BONUS->value,
                ], [
                    'value' => $trcBonus - 0.0001,
                ]);

                $globalService->update([
                    'symbol' => SymbolEnum::TRC_BONUS_DECREASE->value,
                ], [
                    'value' => Carbon::now()->addDays(7)->toDateString(),
                ]);
            }
        }
    }
}
