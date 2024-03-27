<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Payment;

use App\Http\Requests\Api\V3\Public\Billing\Shares\Payment\PaymentMethodsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Services\Utils\MoonpayApiService;

final class PaymentController extends Controller
{
    public function __construct(
        private MoonpayApiService $moonpayApiService,
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
        $data['moonpay']['url'] = $this->moonpayApiService->generateUrlWithSignature("eth");
        return response()->json(['data' => $data]);
    }
}

