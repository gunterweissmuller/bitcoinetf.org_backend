<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\TokenService;
use Closure;

final readonly class FillReplenishmentPipe implements PipeInterface
{
    public function __construct(
        private TokenService $tokenService,
    ) {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $btcPrice = $this->tokenService->getBitcoinAmount();

        $replenishment = $dto->getReplenishment();
        $replenishment->setBtcPrice($btcPrice);
        $replenishment->setStatus(StatusEnum::INIT->value);

        $dto->setReplenishment($replenishment);

        return $next($dto);
    }
}
