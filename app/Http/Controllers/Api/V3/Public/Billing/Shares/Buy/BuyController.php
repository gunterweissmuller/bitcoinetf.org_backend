<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V3\Public\Billing\Shares\Buy;

use App\Dto\Models\Billing\ReplenishmentDto;
use App\Http\Requests\Api\V1\Public\Billing\Shares\Buy\InitRequest;
use App\Pipelines\V3\Public\Billing\Shares\Buy\BuyPipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class BuyController extends Controller
{
    public function __construct(
        private readonly BuyPipeline $pipeline,
    ) {
    }

    public function init(InitRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->init($request->dto());

        if (!$e) {
            /** @var ReplenishmentDto $replenishment */
            $replenishment = $dto->getReplenishment();

            return response()->json([
                'data' => [
                    'uuid' => $replenishment->getUuid(),
                    'dividend_amount' => $replenishment->getDividendAmount(),
                    'referral_amount' => $replenishment->getReferralAmount(),
                    'bonus_amount' => $replenishment->getBonusAmount(),
                    'selected_amount' => $replenishment->getSelectedAmount(),
                    'real_amount' => $replenishment->getRealAmount(),
                    'total_amount' => $replenishment->getTotalAmount(),
                    'tron_wallet' => $dto->getAccount()->getTronWallet(),
                ],
            ]);
        }

        return response()->__call('exception', [$e]);
    }
}
