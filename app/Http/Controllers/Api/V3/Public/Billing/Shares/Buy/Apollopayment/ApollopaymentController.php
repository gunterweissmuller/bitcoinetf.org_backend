<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Enums\Billing\Payment\ApolloPaymentDepositStatusEnum;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\Apollopayment\WebhookRequest;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\TronPipeline;
use App\Services\Api\V1\Settings\GlobalService;
use App\Services\Api\V3\Apollopayment\ApollopaymentWebhooksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApollopaymentController extends Controller
{
    public function __construct(
        private readonly TronPipeline                 $tronPipeline,
        private readonly ApollopaymentWebhooksService $apollopaymentWebhooksService,
    )
    {
    }

    public function webhook(WebhookRequest $request): JsonResponse
    {
        Log::info('Apollo deposit webhook ', $request->all());

        //@fixme-v open after test
        $globalService = app(GlobalService::class);

        if ($request->amount < $globalService->getMinReplenishmentAmount()) {
            Log::info('apollo deposit min amount required', [$request->amount]);

            return response()->json([]);
        }

        if ($request->input('status') !== ApolloPaymentDepositStatusEnum::PROCESSED->value) {
            return response()->json(['status' => $request->input('status')]);
        }

        $this->apollopaymentWebhooksService->create($request->webhook());

        [$dto, $e] = $this->tronPipeline->callback($request->dto());

        if (!$e) {
            return response()->json([]);
        }

        return response()->__call('exception', [$e]);
    }

    public function mockWebhook(WebhookRequest $request): JsonResponse
    {
//        dd(Str::uuid()->toString());
/*        {
  "id": "2fa68ddf-2479-47cb-9e66-ae91139c3063",
  "addressId": "dcb1a9fe-4b8d-40f6-baf6-241dc88436d9",
  "userId": "6196a1f2-b6b5-40a5-a672-f1ffd70fdd7d",
  "amount": "0.005",
  "currency": "USDT",
  "network": "bsc",
  "addressFrom": ["0x....", "0x...."],
  "addressTo": "0x....",
  "status": "PROCESSED",
  "confirmations": 10,
  "tx": "0x5b9b3b55b366266025e",
  "risks": {"level": "yellow", "categories": [{ "level": "yellow", "usdAmount": 41159.8, "category": "stolen funds", "service": "Reported as stolen funds bc1qlf4vel", "exposure": "DIRECT" }],
  "createdAt": "2023-03-02T06:58:00.365Z",
  "updatedAt": "2023-03-02T07:01:50.693Z",
  "webhookId": "b614475d-aa39-49be-b3bf-1622e357a267"
}*/

        return $this->webhook($request);

    }
}
