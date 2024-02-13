<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Billing\Shares\Buy\Fiat;

use App\Dto\Models\Billing\ReplenishmentDto;
use App\Exceptions\Pipelines\V1\Billing\ReplenishmentNotFoundException;
use App\Http\Requests\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\CallbackRequest;
use App\Http\Requests\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\MethodsRequest;
use App\Http\Requests\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\PaymentRequest;
use App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Merchant001Pipeline;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Services\Utils\Merchant001Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class Merchant001Controller extends Controller
{
    public function __construct(
        private readonly Merchant001Pipeline $pipeline,
        private readonly Merchant001Service $merchant001Service,
        private readonly ReplenishmentService $replenishmentService
    ) {
    }

    public function methods(MethodsRequest $request): JsonResponse
    {
        if ($replenishment = $this->replenishmentService->get(['uuid' => $request->dto()->getUuid()])) {
            $rate = $this->merchant001Service->rate()['rate'] ?? 1;
            $amount = 1000 * $rate;

            return response()->json([
                'data' => [
                    'amount_usd' => $replenishment->getRealAmount(),
                    'amount_rub' => $amount,
                    'methods' => $this->merchant001Service->paymentMethods($amount)[0]['methods'] ?? [],
                ],
            ]);
        }

        throw new ReplenishmentNotFoundException();
    }

    public function payment(PaymentRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->payment($request->dto());

        if (!$e) {
            /** @var ReplenishmentDto $replenishment */
            $replenishment = $dto->getReplenishment();

            return response()->json([
                'data' => [
                    'uuid' => $replenishment->getUuid(),
                    'redirect_uri' => 'https://app.merchant001.io/payment/'.$replenishment->getMerchant001Id(),
                ],
            ]);
        }

        return response()->__call('exception', [$e]);
    }

    public function callback(CallbackRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->callback($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('exception', [$e]);
    }
}
