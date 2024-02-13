<?php

declare(strict_types=1);

namespace App\Jobs\V1\Billing\Buy;

use App\Dto\Models\Statistic\DailyAumDto;
use App\Enums\Billing\Payment\TypeEnum;
use App\Jobs\Job;
use App\Models\Billing\Payment;
use App\Services\Api\V1\Statistic\DailyAumService;
use App\Services\Utils\CentrifugalService;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;

final class UpdateDailyAumJob extends Job
{
    use Dispatchable;

    public function __construct()
    {
    }

    public function handle(DailyAumService $dailyAumService, CentrifugalService $centrifugalService): void
    {
        $now = Carbon::now()->setTime(0, 14)->toDateTimeString();

        $this->updateDay(Carbon::parse($now)->toDateTimeString(), true, $dailyAumService, $centrifugalService);

        if (Carbon::parse($now)->hour == 0 && Carbon::parse($now)->minute < 60) {
            $this->updateDay(Carbon::parse($now)->subDay()->toDateTimeString(), false, $dailyAumService, $centrifugalService);
        }
    }

    private function updateDay(
        string $date,
        bool $today,
        DailyAumService $dailyAumService,
        CentrifugalService $centrifugalService
    ): void
    {
        $aumUsd = (float) Payment::query()
            ->selectRaw('SUM(COALESCE(referral_amount,0)+COALESCE(bonus_amount,0)+COALESCE(dividend_amount,0)+COALESCE(real_amount,0)) AS total_amount')
            ->where([
                'type' => TypeEnum::CREDIT_FROM_CLIENT->value,
                ['created_at', '<', Carbon::parse($date)->addDay()->toDateString()],
            ])
            ->value('total_amount');

        if ($aumUsd) {
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

            if ($today) {
                $centrifugalService->publish('events_statistics', [
                    'type' => 'updated_aum',
                    'amount' => $aumUsd,
                ]);
            }
        }
    }
}
