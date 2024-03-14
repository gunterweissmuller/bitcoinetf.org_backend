<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Http\Requests\Api\EmptyRequest;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\Apollopayment\PaymentMethodsRequest;
use App\Services\Api\V3\Apollopayment\ApollopaymentClientsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ApollopaymentController extends Controller
{
    public function __construct(
        private readonly ApollopaymentClientsService $apollopaymentClientsService,

    )
    {
    }

    public function getPaymentsMethods(PaymentMethodsRequest $request): JsonResponse
    {
        $data = [];
        $apolloClient = $this->apollopaymentClientsService->get(['account_uuid' => $request->payload()->getUuid()]);

        if ($apolloClient->getPolygonAddr()) {
            $data['polygon']['address'] = $apolloClient->getPolygonAddr();
        }
        if ($apolloClient->getTronAddr()) {
            $data['tron']['address'] = $apolloClient->getTronAddr();
        }
        if ($apolloClient->getEthereumAddr()) {
            $data['ethereum']['address'] = $apolloClient->getEthereumAddr();
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

    public function webhook(EmptyRequest $request): JsonResponse
    {
        return response()->json([
            'data' => [
                'status' => 'ok',
                'from' => 'webhook',
            ],
        ]);
    }

}
