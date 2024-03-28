<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Payment;

use App\Http\Requests\Api\V3\Public\Billing\Shares\Payment\PaymentMethodsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Services\Utils\MoonpayApiService;
use App\Services\Api\V1\Users\EmailService;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Enums\Billing\Replenishment\StatusEnum;

final class PaymentController extends Controller
{
    public function __construct(
        private readonly MoonpayApiService $moonpayApiService,
        private readonly EmailService $emailService,
        private readonly ReplenishmentService $replenishmentService
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
        $email = $this->emailService->get(['account_uuid' => $accountUuid]);
        if ($replenishment = $this->replenishmentService->get([
            'account_uuid' => $accountUuid,
            'status' => StatusEnum::INIT->value,
        ], function ($query) use ($accountUuid) {
            return $query
                ->orderBy('referral_amount', 'desc')
                ->orderBy('bonus_amount', 'desc')
                ->orderBy('dividend_amount', 'desc');
        })) {
            $data = [];
            $data['moonpay']['url'] = $this->moonpayApiService->generateUrlWithSignature(
                env('MOONPAY_CURRENCY_CODE'),
                $replenishmentAmount = strval(intval($replenishment->getRealAmount())),
                //$email->getEmail(),
                $replenishment->getUuid(),
                $accountUuid
            );
            return response()->json(['data' => $data]);
        } else {
            return response()->json(['data' => 'No replenishment found.']);
        }

    }
}

