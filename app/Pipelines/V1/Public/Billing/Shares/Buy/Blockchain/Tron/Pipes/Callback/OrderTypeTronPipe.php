<?php

declare(strict_types=1);

namespace app\Pipelines\V1\Public\Billing\Shares\Buy\Blockchain\Tron\Pipes\Callback;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Pipelines\PipeInterface;
use Closure;
use App\Enums\Billing\Replenishment\StatusEnum as ReplenishmentStatusEnum;
use App\Enums\Users\Account\OrderTypeEnum;
use App\Services\Api\V1\Users\AccountService;

final readonly class OrderTypeTronPipe implements PipeInterface
{
    public function __construct(
        private AccountService $accountService,
    )
    {
    }

    public function handle(CallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $accountOrderType = $dto->getAccount()->getOrderType();
        $replenishmentOrderType = $dto->getReplenishment()->getOrderType();
        if ($accountOrderType === OrderTypeEnum::InitBTC->value && $dto->getReplenishment()->getStatus() === ReplenishmentStatusEnum::SUCCESS->value)
        {
            if ($replenishmentOrderType === OrderTypeEnum::InitBTC->value){
                $dto->getAccount()->setOrderType(OrderTypeEnum::BTC->value);
            } elseif ($replenishmentOrderType === OrderTypeEnum::InitUSDT->value) {
                $dto->getAccount()->setOrderType(OrderTypeEnum::USDT->value);
            }
            $this->accountService->update([
                'uuid' => $dto->getAccount()->getUuid(),
            ], [
                'order_type' => $dto->getAccount()->getOrderType(),
            ]);
        }

        return $next($dto);
    }
}
