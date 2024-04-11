<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Statistic;

use App\Http\Requests\Api\V1\Public\Statistic\Dividend\GetRequest;
use App\Services\Api\V1\Billing\PaymentService;
use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

final class DividendController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function get(GetRequest $request): JsonResponse
    {
        $year = $request->year();

        $cacheKey = 'statistic.sum_dividends.'.$year;

        if (Cache::has($cacheKey)) {
            $sumDividends = Cache::get($cacheKey);
        } else {
            $sumDividends = $this->paymentService->getTotalDividendsBtcInPeriod(
                $year.'-01-01 00:00:00',
                $year.'-12-31 00:00:00',
            );

            Cache::set($cacheKey, $sumDividends, CarbonInterval::day());
        }

        return response()->json([
            'data' => [
                'sum_dividends' => $sumDividends
            ]
        ]);
    }
}
