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
}
