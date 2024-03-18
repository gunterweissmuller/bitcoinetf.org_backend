<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Enums\Billing\Payment\ApolloPaymentDepositStatusEnum;
use App\Http\Requests\Api\EmptyRequest;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\Apollopayment\PaymentMethodsRequest;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\TronPipeline;
use App\Services\Api\V3\Apollopayment\ApollopaymentClientsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ApollopaymentController extends Controller
{
    public function __construct(
        private readonly ApollopaymentClientsService $apollopaymentClientsService,
        private readonly TronPipeline $pipeline,
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

    public function webhook(PaymentMethodsRequest $request): JsonResponse
    {
        if ($request->status === ApolloPaymentDepositStatusEnum::PENDING) {
            return response()->json([]);
        }

        [$dto, $e] = $this->pipeline->callback($request->dto());

        if (!$e) {
            return response()->json([]);
        }

        return response()->__call('exception', [$e]);
    }

}
