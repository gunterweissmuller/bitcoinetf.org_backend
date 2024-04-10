<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Enums\Billing\Payment\ApolloPaymentDepositStatusEnum;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\Apollopayment\WebhookRequest;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\TronPipeline;
use App\Services\Api\V1\Settings\GlobalService;
use App\Services\Api\V3\Apollopayment\ApollopaymentWebhooksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

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
//        $globalService = app(GlobalService::class);
//
//        if ($request->amount < $globalService->getMinReplenishmentAmount()) {
//            Log::info('apollo deposit min amount required', [$request->amount]);
//
//            return response()->json([]);
//        }

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
}
