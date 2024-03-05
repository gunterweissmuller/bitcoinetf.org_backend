<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\ReplenishmentService;
use Closure;

final readonly class ReplenishmentPipe implements PipeInterface
{
    public function __construct(
        private ReplenishmentService $replenishmentService,
    ) {
    }

    public function handle(CallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $accountUuid = $dto->getAccount()->getUuid();

        if ($replenishment = $this->replenishmentService->get([
            'account_uuid' => $accountUuid,
            'status' => StatusEnum::INIT->value,
        ], function ($query) use ($accountUuid) {
            return $query
                ->orderBy('referral_amount', 'desc')
                ->orderBy('bonus_amount', 'desc')
                ->orderBy('dividend_amount', 'desc');
        })) {
            $dto->setReplenishment($replenishment);
            $dto->setIsReplenishment(true);
        } else {
            $replenishment = $dto->getReplenishment();

            $replenishment->setAccountUuid($accountUuid);
            $replenishment->setTotalAmountBtc((1 / $replenishment->getBtcPrice() * $replenishment->getRealAmount()) + $replenishment->getDividendBtcAmount());

            $dto->setIsReplenishment(false);
        }

        return $next($dto);
    }
}
