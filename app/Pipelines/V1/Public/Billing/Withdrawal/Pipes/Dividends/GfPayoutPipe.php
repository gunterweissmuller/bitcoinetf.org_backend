<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Dto\Pipelines\Utils\Greenfield\PayoutDto;
use App\Enums\Billing\Withdrawal\MethodEnum;
use App\Enums\Billing\Withdrawal\StatusEnum;
use App\Exceptions\Pipelines\V1\Billing\WithdrawalNotPossibleException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WithdrawalService;
use App\Services\Utils\GreenfieldService;
use Closure;

final class GfPayoutPipe implements PipeInterface
{
    public function __construct(
        private readonly GreenfieldService $greenfieldService,
        private readonly WithdrawalService $withdrawalService,
    ) {
    }

    public function handle(DividendPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $wallet = $dto->getWallet();

        $payment = $dto->getPayment();
        $pullPayment = $dto->getPullPayment();
        $withdrawal = $dto->getWithdrawal();

        if ($payout = $this->greenfieldService->createPayouts($pullPayment->getId(), PayoutDto::fromArray([
            'destination' => $wallet->getWithdrawalAddress(),
            'amount' => $payment->getTotalAmount(),
            'paymentMethod' => ($dto->getMethod() == MethodEnum::BITCOIN_ON_CHAIN->value) ? 'BTC-OnChain' : 'BTC-LightningNetwork',
        ]))) {
            $dto->setPayout($payout);
        } else {
            throw new WithdrawalNotPossibleException();
        }

        $withdrawal->setStatus(StatusEnum::SUCCESS->value);
        $this->withdrawalService->update([
            'uuid' => $withdrawal->getUuid(),
        ], [
            'status' => $withdrawal->getStatus()
        ]);

        return $next($dto);
    }
}
