<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\Pipes\Callback;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\CallbackPipelineDto;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Exceptions\Pipelines\V1\Billing\ReplenishmentNotFoundException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Services\Api\V1\Billing\TokenService;
use Closure;

final class ReplenishmentPipe implements PipeInterface
{
    public function __construct(
        private readonly ReplenishmentService $replenishmentService,
        private readonly TokenService $tokenService,
    ) {
    }

    public function handle(CallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $replenishment = $dto->getReplenishment();

        if ($replenishment = $this->replenishmentService->get(array_filter($replenishment->toArray()))) {
            $btcPrice = $this->tokenService->getBitcoinAmount();

            $replenishment->setTotalAmountBtc(1 / $btcPrice * $replenishment->getTotalAmount());
            $replenishment->setBtcPrice($btcPrice);

            $this->replenishmentService->update([
                'uuid' => $replenishment->getUuid(),
            ], [
                'total_amount_btc' => $replenishment->getTotalAmountBtc(),
                'btc_price' => $replenishment->getBtcPrice(),
            ]);

            if ($replenishment->getStatus() == StatusEnum::SUCCESS->value || $replenishment->getStatus() == StatusEnum::EXPIRED->value) {
                $dto->setIsReplenished(true);
            }

            $dto->setReplenishment($replenishment);
        } else {
            throw new ReplenishmentNotFoundException();
        }

        return $next($dto);
    }
}
