<?php

declare(strict_types=1);

namespace app\Http\Controllers\Api\V3\Public\Billing;

use App\Dto\Models\Apollopayment\WebhooksDto;
use App\Enums\Billing\Payment\ApolloPaymentWebhookTypeEnum;
use App\Enums\Billing\Payment\ApolloPaymentWithdrawalStatusEnum;
use App\Http\Requests\Api\V3\Public\Billing\Withdrawal\Apollopayment\WebhookRequest;
use App\Services\Api\V1\Billing\WithdrawalService;
use App\Pipelines\V1\Public\Billing\Withdrawal\WithdrawalPipeline;
use App\Services\Api\V3\Apollopayment\ApollopaymentWebhooksService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

final class WithdrawalController extends Controller
{
    public function __construct(
        private readonly ApollopaymentWebhooksService $apollopaymentWebhooksService,
        private readonly WithdrawalPipeline $pipeline,
        private readonly WithdrawalService $withdrawalService,
    ) {
    }


    public function webhook(WebhookRequest $request): JsonResponse
    {
        Log::info('apollo withdrawal webhook', $request->all());
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

        if ($request->input('status') === ApolloPaymentWithdrawalStatusEnum::PROCESSED->value) {
            $withdrawal = $this->withdrawalService->get(['uuid' => request()->withdrawal_uuid]);
            $accountUuid = $withdrawal->getAccountUuid();
            //TODO WebhooksDto setting move to WebhookRequest
            $this->apollopaymentWebhooksService->create(WebhooksDto::fromArray([
                'client_id' => $accountUuid,
                'webhook_id' => $request->input('webhookId'),
                'address_id' => $request->input('addressId'),
                'amount' => (float)$request->input('amount'),
                'currency' => $request->input('currency'),
                'network' => $request->input('network'),
                'tx' => $request->input('tx'),
                'type' => ApolloPaymentWebhookTypeEnum::WITHDRAW->value,
            ]));

            [$dto, $e] = $this->pipeline->apolloWithdrawalWebhook($request->dividendPipelineDto());

            if (!$e) {
                return response()->json();
            }

            return response()->__call('exception', [$e]);
        }

        return response()->json(['status' => 'unsupported webhook status',]);
    }

    public function mock(WebhookRequest $request): JsonResponse
    {
        if ($request->header('API-Key') !== 'ac2136bf-95ae-40e0-ab61-3b6b1165ee32') {
            return response()->json(['error' => 'Invalid API key'], 401);
        }
        
        // Execute command for bitcoin-apollo-polygon-usdt-withdrawal
        Artisan::call('billing:bitcoin-apollo-polygon-usdt-withdrawal');
        // You can return the output if needed
        return response()->json([
            'status' => 'ok',
            'output' => Artisan::output()
        ]);
    }
}
