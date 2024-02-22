<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\ReferralsCallback;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralCallbackPipelineDto;
use App\Enums\Billing\Withdrawal\StatusEnum;
use App\Exceptions\Pipelines\V1\Billing\WithdrawalNotPossibleException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Billing\WithdrawalService;
use Closure;

final readonly class WithdrawalPipe implements PipeInterface
{
    public function __construct(
        private WithdrawalService $withdrawalService,
        private TokenService $tokenService,
    ) {
    }

    public function handle(ReferralCallbackPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $withdrawal = $dto->getWithdrawal();
        $withdrawal->setStatus(StatusEnum::PENDING->value);

        if ($withdrawal = $this->withdrawalService->get(array_filter($withdrawal->toArray()))) {
            $btcPrice = $this->tokenService->getBitcoinAmount();

            $withdrawal->setTotalAmountBtc(1 / $btcPrice * $withdrawal->getTotalAmount());
            $withdrawal->setBtcPrice($btcPrice);

            $this->withdrawalService->update([
                'uuid' => $withdrawal->getUuid(),
            ], [
                'total_amount_btc' => $withdrawal->getTotalAmountBtc(),
                'btc_price' => $withdrawal->getBtcPrice(),
            ]);

            $dto->setWithdrawal($withdrawal);
        } else {
            throw new WithdrawalNotPossibleException();
        }

        return $next($dto);
    }
}
