<?php

declare(strict_types=1);

namespace app\Http\Controllers\Api\V3\Public\Billing;

use App\Enums\Billing\Payment\ApolloPaymentWithdrawalStatusEnum;
use App\Http\Requests\Api\V3\Public\Billing\Withdrawal\Apollopayment\WebhookRequest;
use App\Services\Api\V3\Apollopayment\ApollopaymentClientsService;
use App\Services\Api\V3\Apollopayment\ApollopaymentWebhooksService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class WithdrawalController extends Controller
{
    public function __construct(
        //private readonly ApollopaymentClientsService $apollopaymentClientsService,
        private readonly ApollopaymentWebhooksService $apollopaymentWebhooksService,
    ) {
    }


    public function webhook(WebhookRequest $request): JsonResponse
    {
        Log::info('apollo webhook', $request->all());
//TODO uncomment
//        $globalService = app(GlobalService::class);
//
//        if ($request->amount < $globalService->getMinReplenishmentAmount()) {
//            Log::info('apollo deposit min amount required', [$request->amount]);
//
//            return response()->json([]);
//        }

        if ($request->input('status') === ApolloPaymentWithdrawalStatusEnum::ERROR->value) {
            return response()->json(['status' => ApolloPaymentWithdrawalStatusEnum::ERROR->value]);
        }

        $this->apollopaymentWebhooksService->create($request->webhook());

        // [$dto, $e] = $this->tronPipeline->callback($request->dto());

        // if (!$e) {
        //     return response()->json([]);
        // }

        // return response()->__call('exception', [$e]);

        return response()->json([
        'status' => 'ок',
        // 'account_uuid' => request()->account_uuid,
        // 'request' => $request->all(),
         ]);
    }
}
