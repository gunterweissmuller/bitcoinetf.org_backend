<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Statistic;

use App\Enums\Billing\Payment\TypeEnum;
use App\Http\Requests\Api\V1\Public\Statistic\Shareholder\ListRequest;
use App\Models\Fund\Shareholder;
use App\Services\Api\V1\Fund\ShareholderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

final class ShareholderController extends Controller
{
    public function __construct(
        private readonly ShareholderService $shareholderService
    ) {
    }

    public function count(): JsonResponse
    {
        return response()->json([
            'data' => [
                'count' => $this->shareholderService->getCount([])
            ],
        ]);
    }

    public function top(ListRequest $request): JsonResponse
    {
        $shareholdersTop = $this->shareholderService->getTop($request->dto(), ['account_uuid', 'total_payments']);
        $accountsUuid = $shareholdersTop?->getCollection()?->pluck('account.uuid');
        $totalDividendsByAccounts = DB::table('billing.payments')
            ->selectRaw('account_uuid, SUM(dividend_amount)')
            ->where(['type' => TypeEnum::DEBIT_TO_CLIENT->value])
            ->whereIn('account_uuid', $accountsUuid)
            ->groupBy('account_uuid')
            ->get();

        // TODO: Костыль на total_dividends поздже поправить
        $shareholdersTop->through(function (Shareholder $value) use ($totalDividendsByAccounts) {
            $data = $value->toArray();
            $data['total_dividends'] = (float)$totalDividendsByAccounts->where('account_uuid', $data['account_uuid'])->value('sum');

            return $data;
        });

        return response()->json([
            'data' => $shareholdersTop,
        ]);
    }
}
