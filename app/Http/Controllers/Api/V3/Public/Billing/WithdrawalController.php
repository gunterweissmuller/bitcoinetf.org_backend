<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing;

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
use App\Services\Api\V3\Billing\SellService;

final class WithdrawalController extends Controller
{
    public function __construct(
        private readonly ApollopaymentWebhooksService $apollopaymentWebhooksService,
        private readonly WithdrawalPipeline           $pipeline,
        private readonly WithdrawalService            $withdrawalService,
        private readonly SellService                  $sellService,
    )
    {
    }


    public function webhook(WebhookRequest $request): JsonResponse
    {
        Log::info('apollo withdrawal webhook', $request->all());

        if ($request->input('status') !== ApolloPaymentWithdrawalStatusEnum::PROCESSED->value) {
            return response()->json(['status' => $request->input('status')]);
        }

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

    //@fixme-v open after test delete after test
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

    /**
     * @param WebhookRequest $request
     * @return JsonResponse
     */
    public function webhookReferral(WebhookRequest $request): JsonResponse
    {
        Log::info('apollo withdrawal referral webhook', $request->all());

        if ($request->input('status') !== ApolloPaymentWithdrawalStatusEnum::PROCESSED->value) {
            return response()->json(['status' => $request->input('status')]);
        }

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
            'payload' => json_encode($request->all(), JSON_UNESCAPED_SLASHES),
        ]));

        [$dto, $e] = $this->pipeline->apolloWithdrawalWebhook($request->referralPipelineDto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }

    /**
     * @param WebhookRequest $request
     * @return JsonResponse
     */
    public function mockWebhookReferral(WebhookRequest $request): JsonResponse
    {
        /*        {
          "id": "2fa68ddf-2479-47cb-9e66-ae91139c3063",
          "addressId": "dcb1a9fe-4b8d-40f6-baf6-241dc88436d9",
          "userId": "6196a1f2-b6b5-40a5-a672-f1ffd70fdd7d",
          "amount": "0.005",
          "currency": "USDT",
          "network": "bsc",
          "addressFrom": ["0x....", "0x...."],
          "addressTo": "0x....",
          "status": "processed",
          "confirmations": 10,
          "tx": "0x5b9b3b55b366266025e",
          "risks": {"level": "yellow", "categories": [{ "level": "yellow", "usdAmount": 41159.8, "category": "stolen funds", "service": "Reported as stolen funds bc1qlf4vel", "exposure": "DIRECT" }],
          "createdAt": "2023-03-02T06:58:00.365Z",
          "updatedAt": "2023-03-02T07:01:50.693Z",
          "webhookId": "b614475d-aa39-49be-b3bf-1622e357a267"
        }*/

        return $this->webhookReferral($request);
    }

    /**
     * @param WebhookRequest $request
     * @return JsonResponse
     */
    public function mockReferralCommand(WebhookRequest $request): JsonResponse
    {
        if ($request->header('API-Key') !== 'ac2136bf-95ae-40e0-ab61-3b6b1165ee32') {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        Artisan::call('billing:apollo-polygon-usdt-withdrawal-referral');
        return response()->json([
            'status' => 'ok',
            'output' => Artisan::output()
        ]);
    }

    /**
     * @param WebhookRequest $request
     * @return JsonResponse
     */
    public function webhookPayout(WebhookRequest $request): JsonResponse
    {
        Log::info('apollo payout sell webhook', $request->all());

        if ($request->input('status') !== ApolloPaymentWithdrawalStatusEnum::PROCESSED->value) {
            return response()->json(['status' => $request->input('status')]);
        }

        $sell = $this->sellService->get(['uuid' => request()->sell_uuid]);
        $accountUuid = $sell->getAccountUuid();

        //TODO WebhooksDto setting move to WebhookRequest
        $this->apollopaymentWebhooksService->create(WebhooksDto::fromArray([
            'client_id' => $accountUuid,
            'webhook_id' => $request->input('webhookId'),
            'address_id' => $request->input('addressId'),
            'amount' => (float)$request->input('amount'),
            'currency' => $request->input('currency'),
            'network' => $request->input('network'),
            'tx' => $request->input('tx'),
            'type' => ApolloPaymentWebhookTypeEnum::PAYOUT->value,
            'payload' => json_encode($request->all(), JSON_UNESCAPED_SLASHES),
        ]));

        [$dto, $e] = $this->pipeline->apolloPayoutWebhook($request->payoutPipelineDto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }
}
