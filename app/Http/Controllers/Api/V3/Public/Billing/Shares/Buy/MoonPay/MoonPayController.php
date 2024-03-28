<?php

declare(strict_types=1);

namespace app\Http\Controllers\Api\V3\Public\Billing\Shares\Buy\MoonPay;

use App\Enums\Billing\Payment\ApolloPaymentDepositStatusEnum;
use App\Http\Requests\Api\EmptyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use App\Services\Api\V1\Apollopayment\ApollopaymentWebhooksService;

class MoonPayController extends Controller
{
    public function __construct(
        private ApollopaymentWebhooksService $apollopaymentWebhooksService,
    )
    {
    }

    public function webhook(EmptyRequest $request): JsonResponse
    {
        Log::info('MoonPay webhook', $request->all());
        //if ($request->input('status') === '') {
        //    return response()->json(['status' => '']);
        //}
        $this->apollopaymentWebhooksService->createMoonPayWebhookRecord($request);
        return response()->json([
            'data' => [
                'status' => 'ok',
                'from' => 'moonpay',
                'webhook' => $request->all(),
            ],
        ]);
    }

}
