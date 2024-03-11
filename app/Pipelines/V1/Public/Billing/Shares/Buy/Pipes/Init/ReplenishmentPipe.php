<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\ReplenishmentService;
use App\Services\Api\V1\Settings\GlobalService;
use Closure;

final readonly class ReplenishmentPipe implements PipeInterface
{
    public function __construct(
        private ReplenishmentService $replenishmentService,
        private GlobalService $globalService,
    ) {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $replenishment = $dto->getReplenishment();

        $btcPrice = $replenishment->getBtcPrice();

        $trcBonus = number_format($this->globalService->getTrcBonus(), 8, '.', '');
//        if ($trcBonus > 0) {
//            $realAmount = $replenishment->getRealAmount() - $replenishment->getRealAmount() * $trcBonus;
//            $replenishment->setRealAmount($realAmount);
//        }

        $replenishment->setAccountUuid($dto->getAccount()->getUuid());
        $replenishment->setTotalAmount($replenishment->getReferralAmount() + $replenishment->getBonusAmount() + $replenishment->getRealAmount() + $replenishment->getDividendAmount());
        $replenishment->setTotalAmountBtc(1 / $btcPrice * $replenishment->getTotalAmount());

        $replenishment = $this->replenishmentService->create($replenishment);

        $dto->setReplenishment($replenishment);

        return $next($dto);
    }
}
