<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Statistic;

use App\Enums\Settings\Global\DividendReportLifeTimeEnum;
use App\Enums\Storage\File\TypeEnum as FileTypeEnum;
use App\Http\Requests\Api\V1\Public\Statistic\Dividend\GetRequest;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Storage\FileService;
use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

final class DividendController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly FileService    $fileService
    )
    {
    }

    public function get(GetRequest $request): JsonResponse
    {
        $year = $request->year();

        $cacheKey = 'statistic.sum_dividends.' . $year;

        if (Cache::has($cacheKey)) {
            $sumDividends = Cache::get($cacheKey);
        } else {
            $sumDividends = $this->paymentService->getTotalDividendsBtcInPeriod(
                $year . '-01-01 00:00:00',
                $year . '-12-31 00:00:00',
            );

            Cache::set($cacheKey, $sumDividends, CarbonInterval::day());
        }

        return response()->json([
            'data' => [
                'sum_dividends' => $sumDividends
            ]
        ]);
    }

    /**
     * @param string $fileUuid
     * @return RedirectResponse
     */
    public function monthlyDividendsReport(string $fileUuid): RedirectResponse
    {
        try {
            $errorMessageTitle = 'Monthly Dividends report (action -> /v1/public/statistic/monthly-dividends-report/{file_uuid}): ';
            $fileService = $this->fileService->get([
                'uuid' => $fileUuid,
                'type' => FileTypeEnum::DividendsReport->value,
            ], true);

            if (!$fileService) {
                Log::error("$errorMessageTitle not found file by this file_uuid - $fileUuid");
                return redirect()->away(env('APP_URL'));
            }

            if (!Storage::disk('s3')->exists($fileService->getPath())) {
                Log::error("$errorMessageTitle not found file on AWS by this file_uuid - $fileUuid");
                return redirect()->away(env('APP_URL'));
            }

            $redirectUrl = Storage::disk('s3')->temporaryUrl(
                $fileService->getPath(),
                Carbon::now()->addSeconds((int)DividendReportLifeTimeEnum::EVERY_TIME->value)
            );

            return redirect()->away($redirectUrl);
        } catch (\Exception $e) {
            Log::error($errorMessageTitle . $e->getMessage());
            return redirect()->away(env('APP_URL'));
        }
    }
}
