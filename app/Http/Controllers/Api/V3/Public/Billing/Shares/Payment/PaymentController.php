<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Payment;

use App\Http\Requests\Api\V3\Public\Billing\Shares\Payment\PaymentMethodsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class PaymentController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @param PaymentMethodsRequest $request
     * @return JsonResponse
     */
    public function getPaymentsMethods(PaymentMethodsRequest $request): JsonResponse
    {
        $data = [];
        $data['moonpay']['address'] = env('BASIC_APOLLO_WALLET_POLYGON_USDT_ADDRESS');
        return response()->json(['data' => $data]);
    }
}

