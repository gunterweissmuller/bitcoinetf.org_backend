<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Services\Api\V1\Billing\TokenService;
use Closure;

final readonly class ReplenishmentPipe implements PipeInterface
{
    public function __construct(
        private TokenService $tokenService,
        private ReplenishmentService $replenishmentService,
    ) {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $btcPrice = $this->tokenService->getBitcoinAmount();

        $replenishment = $dto->getReplenishment();
        $replenishment->setAccountUuid($dto->getAccount()->getUuid());
        $replenishment->setTotalAmount($replenishment->getReferralAmount() + $replenishment->getDividendAmount() + $replenishment->getBonusAmount() + $replenishment->getRealAmount());
        $replenishment->setTotalAmountBtc(1 / $btcPrice * $replenishment->getTotalAmount());
        $replenishment->setBtcPrice($btcPrice);
        $replenishment->setStatus(StatusEnum::INIT->value);

        $replenishment = $this->replenishmentService->create($replenishment);

        $dto->setReplenishment($replenishment);

        return $next($dto);
    }
}
