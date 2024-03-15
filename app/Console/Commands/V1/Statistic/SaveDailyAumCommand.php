<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Statistic;

use App\Dto\Models\Statistic\DailyAumDto;
use App\Enums\Billing\Payment\TypeEnum;
use App\Models\Billing\Payment;
use App\Services\Api\V1\Statistic\DailyAumService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

final class SaveDailyAumCommand extends Command
{
    protected $signature = 'statistic:save-daily-aum';

    protected $description = 'Сохраняем баланс активов под управлением в конце дня для ежедневной статистики';

    public function handle(DailyAumService $dailyAumService): void
    {
        $now = Carbon::now()->setTime(0, 14)->toDateTimeString();

        $this->updateDay(Carbon::parse($now)->toDateTimeString(), $dailyAumService);

        if (Carbon::parse($now)->hour == 0 && Carbon::parse($now)->minute < 60) {
            $this->updateDay(Carbon::parse($now)->subDay()->toDateTimeString(), $dailyAumService);
        }
    }

    private function updateDay(string $date, DailyAumService $dailyAumService): void
    {
        $aumUsd = (float) Payment::query()
            ->selectRaw('SUM(COALESCE(referral_amount,0)+COALESCE(bonus_amount,0)+COALESCE(dividend_amount,0)+COALESCE(real_amount,0)) AS total_amount')
            ->where([
                'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
                ['real_amount', '!=', null],
                ['created_at', '<', Carbon::parse($date)->addDay()->toDateString()],
            ])
            ->value('total_amount');

        if ($dailyAum = $dailyAumService->get(['created_at' => Carbon::parse($date)->toDateString()])) {
            $dailyAumService->update([
                'uuid' => $dailyAum->getUuid(),
            ], [
                'amount' => $aumUsd,
            ]);
        } else {
            $dailyAumService->create(DailyAumDto::fromArray([
                'amount' => $aumUsd,
                'created_at' => Carbon::parse($date)->toDateString(),
            ]));
        }
    }
}
