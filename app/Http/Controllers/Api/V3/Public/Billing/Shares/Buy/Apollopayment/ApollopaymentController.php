<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Enums\Billing\Payment\ApolloPaymentDepositStatusEnum;
use App\Http\Requests\Api\EmptyRequest;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\Apollopayment\CancelOrderRequest;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\Apollopayment\PaymentMethodsRequest;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\Apollopayment\WebhookRequest;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\TronPipeline;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Apollopayment\ApollopaymentPipeline;
use App\Services\Api\V1\Settings\GlobalService;
use App\Services\Api\V3\Apollopayment\ApollopaymentClientsService;
use App\Services\Api\V3\Apollopayment\ApollopaymentWebhooksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use App\Dto\Models\Apollopayment\WebhooksDto;
use App\Enums\Billing\Payment\ApolloPaymentWebhookTypeEnum;

class ApollopaymentController extends Controller
{
    public function __construct(
        private readonly ApollopaymentClientsService $apollopaymentClientsService,
        private readonly TronPipeline $tronPipeline,// @fixme change this pipe to new pipe
        private readonly ApollopaymentPipeline $pipeline,
        private readonly ApollopaymentWebhooksService $apollopaymentWebhooksService,
    )
    {
    }

    /**
     * @param PaymentMethodsRequest $request
     * @return JsonResponse
     */
    public function getPaymentsMethods(PaymentMethodsRequest $request): JsonResponse
    {
        $data = [];
        $apolloClient = $this->apollopaymentClientsService->get(['account_uuid' => $request->payload()->getUuid()]);

        if ($apolloClient) {
            if ($apolloClient->getPolygonAddr()) {
                $data['polygon']['address'] = $apolloClient->getPolygonAddr();
            }
            if ($apolloClient->getTronAddr()) {
                $data['tron']['address'] = $apolloClient->getTronAddr();
            }
            if ($apolloClient->getEthereumAddr()) {
                $data['ethereum']['address'] = $apolloClient->getEthereumAddr();
            }
        }

        return response()->json(['data' => $data]);
    }

    public function check(EmptyRequest $request): JsonResponse
    {
        return response()->json([
            'data' => [
                'status' => 'ok',
                'from' => 'check',
            ],
        ]);
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

        if ($request->input('status') === ApolloPaymentDepositStatusEnum::PENDING->value) {
            return response()->json(['status' => ApolloPaymentDepositStatusEnum::PENDING->value]);
        }

        $dto = new WebhooksDto(
            null,
            request()->account_uuid,
            $request->input('webhookId'),
            $request->input('addressId'),
            (float)$request->input('amount')??null,
            $request->input('currency')??null,
            $request->input('network')??null,
            $request->input('tx')??null,
            ApolloPaymentWebhookTypeEnum::DEPOSIT->value,
            null,
            null,
        );

        $this->apollopaymentWebhooksService->create($dto);

        [$dto, $e] = $this->tronPipeline->callback($request->dto());

        if (!$e) {
            return response()->json([]);
        }

        return response()->__call('exception', [$e]);
    }

    /**
     * @param CancelOrderRequest $request
     * @return JsonResponse
     */
    public function cancelOrder(CancelOrderRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->cancelOrder($request->dto());

        if (!$e) {
            return response()->json([]);
        }

        return response()->__call('exception', [$e]);
    }
}
