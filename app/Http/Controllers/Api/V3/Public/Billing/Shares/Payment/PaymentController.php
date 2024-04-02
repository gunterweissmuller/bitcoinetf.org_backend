<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Payment;

use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Payment\CancelOrderPipelineDto;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Payment\CancelOrderRequest;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Payment\PaymentMethodsRequest;
use App\Pipelines\V3\Public\Billing\Shares\Buy\Payment\PaymentPipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Services\Utils\MoonpayApiService;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Enums\Billing\Replenishment\StatusEnum;

final class PaymentController extends Controller
{
    public function __construct(
        private readonly MoonpayApiService     $moonpayApiService,
        private readonly ReplenishmentService  $replenishmentService,
        private readonly PaymentPipeline $pipeline,
    )
    {
    }

    /**
     * @param PaymentMethodsRequest $request
     * @return JsonResponse
     */
    public function getPaymentsMethods(PaymentMethodsRequest $request): JsonResponse
    {
        $accountUuid = $request->payload()->getUuid();
        $replenishmentUuid = $request->input('replenishment_uuid');
        $replenishment = $this->replenishmentService->get([
            'uuid' => $replenishmentUuid,
            'account_uuid' => $accountUuid,
            'status' => StatusEnum::INIT->value,
        ]);
        if ($replenishment) {
            $data = [];
            $data['moonpay']['url'] = $this->moonpayApiService->generateUrlWithSignature(
                env('MOONPAY_CURRENCY_CODE'),
                $replenishmentAmount = strval(intval($replenishment->getRealAmount())),
                $replenishment->getUuid(),
                $accountUuid
            );
            return response()->json(['data' => $data]);
        } else {
            return response()->json(['data' => 'No replenishment found.']);
        }

    }

    /**
     * @param CancelOrderRequest $request
     * @return JsonResponse
     */
    public function cancelOrder(CancelOrderRequest $request): JsonResponse
    {
        /** @var CancelOrderPipelineDto $dto */
        [$dto, $e] = $this->pipeline->cancelOrder($request->dto());

        if (!$e) {
            return response()->json([]);
        }

        return response()->__call('exception', [$e]);
    }
}

