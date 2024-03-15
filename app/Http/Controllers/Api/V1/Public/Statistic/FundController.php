<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Statistic;

use App\Enums\Billing\Payment\TypeEnum;
use App\Http\Requests\Api\V1\Public\Statistic\Funds\MainRequest;
use App\Models\Billing\Payment;
use App\Models\Statistic\DailyAum;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Statistic\DailyAumService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;

final class FundController extends Controller
{
    public function __construct(
        private readonly TokenService $tokenService,
    ) {
    }

    public function main(MainRequest $request): JsonResponse
    {
        $viewFormat = 'Y';
        $btcPrice = $this->tokenService->getBitcoinAmount();

        $dto = $request->dto();
        $filters = $dto->getFilters();
        $periodTo = Carbon::yesterday()->toDateString();

        $dto->setFilters($filters);

        if (isset($filters['period_from'])) {
            if (Carbon::parse($filters['period_from'])->diffInMonths(Carbon::parse($periodTo)) < 2) {
                $viewFormat = 'd.m';
            } elseif (Carbon::parse($filters['period_from'])->diffInMonths(Carbon::parse($periodTo)) >= 2 && Carbon::parse($filters['period_from'])->diffInMonths(Carbon::parse($periodTo)) < 12) {
                $viewFormat = 'm.y';
            } elseif (Carbon::parse($filters['period_from'])->diffInMonths(Carbon::parse($periodTo)) >= 12 && Carbon::parse($filters['period_from'])->diffInMonths(Carbon::parse($periodTo)) < 24) {
                $viewFormat = 'quarter';
            }
        }

        $aumUsd = DailyAum::query()
            ->orderBy('created_at', 'desc')
            ->value('amount');

        $aumBtc = bcmul(
            bcdiv(
                '1',
                (string) $btcPrice,
                8
            ),
            (string) $aumUsd,
            8
        );

        $aumFirstDate = DailyAum::query()->orderBy('created_at')->value('created_at');
        $aumDataMouths = DailyAum::query();
        if (isset($filters['period_from'])) {
            $aumDataMouths = $aumDataMouths->where([
                ['created_at', '>=', Carbon::parse($filters['period_from'])->toDateTimeString()],
            ]);
        }
        $aumDataMouths = $aumDataMouths->orderBy('created_at')->get()->toArray();
        $aumFirstDataMouth = DailyAum::query()->orderBy('created_at')->limit(1)->first();

        if (!isset($filters['period_from']) &&$aumFirstDataMouth['created_at']) {
            if (Carbon::parse($aumFirstDataMouth['created_at'])->diffInMonths(Carbon::now()) < 2) {
                $viewFormat = 'd.m';
            } elseif (Carbon::parse($aumFirstDataMouth['created_at'])->diffInMonths(Carbon::now()) >= 2 && Carbon::parse($aumDataMouths[count($aumDataMouths) - 1]['created_at'])->diffInMonths(Carbon::now()) < 12) {
                $viewFormat = 'm.y';
            } elseif (Carbon::parse($aumFirstDataMouth['created_at'])->diffInMonths(Carbon::now()) >= 12 && Carbon::parse($aumDataMouths[count($aumDataMouths) - 1]['created_at'])->diffInMonths(Carbon::now()) < 24) {
                $viewFormat = 'quarter';
            }
        }

        foreach ($aumDataMouths as $i => $aumDataMouth) {
            $aumDataMouths[$i] = [
                'amount' => (string)$aumDataMouth['amount'],
                'label' => ($viewFormat != 'quarter')
                    ? Carbon::parse($aumDataMouth['created_at'])->format($viewFormat)
                    : 'Q' . Carbon::parse($aumDataMouth['created_at'])->quarter . ' ' . Carbon::parse($aumDataMouth['created_at'])->format('Y'),
                'created_at' => Carbon::parse($aumDataMouth['created_at'])->format('Y-m-d'),
            ];
        }

        $aumDateMouths = [];
        foreach ($aumDataMouths as $i => $aumDataMouth) {
            if (isset($aumDataMouths[$i+1])) {
                if ($viewFormat == 'quarter') {
                    if (Carbon::parse($aumDataMouth['created_at'])->quarter != Carbon::parse($aumDataMouths[$i+1]['created_at'])->quarter) {
                        $aumDateMouths[$i] = $aumDataMouth;
                    }
                } elseif ($viewFormat == 'm.y') {
                    if (Carbon::parse($aumDataMouth['created_at'])->month != Carbon::parse($aumDataMouths[$i+1]['created_at'])->month) {
                        $aumDateMouths[$i] = $aumDataMouth;
                    }
                } else {
                    $aumDateMouths[$i] = $aumDataMouth;
                }
            } else {
                $aumDateMouths[$i] = $aumDataMouth;
            }
        }
        unset($aumDataMouths);

        $aumMouths = array_reverse(array_values($aumDateMouths));
        unset($aumDateMouths);

        if (isset($filters['period_from']) && Carbon::parse($filters['period_from']) < Carbon::parse($aumFirstDate)) {
            $aumMouths[] = [
                'amount' => '0',
                'label' => '01.01.1970',
                'created_at' => '1970-01-01'
            ];
        } elseif (!isset($filters['period_from'])) {
            $aumMouths[] = [
                'amount' => '0',
                'label' => '01.01.1970',
                'created_at' => '1970-01-01'
            ];
        }

        $aumFirstUsd = $aumMouths[count($aumMouths) - 1]['amount'];
        $aumLastUsd = $aumMouths[0]['amount'];

        if ($aumFirstUsd == '0') {
            $difference = 100;
        } else {
            $difference = $aumUsd
                ? (float)bcmul(
                    bcsub(
                        bcdiv(
                            $aumLastUsd,
                            $aumFirstUsd,
                            8
                        ),
                        '1',
                        8
                    ),
                    '100',
                    2
                )
                : 0;
        }

        if (isset($filters['period_from'])) {
            $differenceUsd = (float)bcsub($aumLastUsd, $aumFirstUsd);
        } else {
            $differenceUsd = (float)$aumUsd;
        }

        foreach ($aumMouths as $i => $aumMouth) {
            $aumMouths[$i]['amount'] = (float)$aumMouth['amount'];
        }

        return response()->json([
            'total_amount_usd' => (float)$aumUsd,
            'total_amount_btc' => (float)$aumBtc,
            'difference' => $difference,
            'difference_usd' => $differenceUsd,
            'data' => array_values($aumMouths),
        ]);
    }
}
