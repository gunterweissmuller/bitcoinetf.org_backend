<?php

declare(strict_types=1);

namespace App\Pipelines\V3\Public\Billing\Shares\Buy\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WalletService;
use Closure;

final readonly class BonusPipe implements PipeInterface
{
    public function __construct(
        private WalletService $walletService,
    ) {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();
        $replenishment = $dto->getReplenishment();

        if ($dto->getBonus() === true) {
            if ($wallet = $this->walletService->get([
                'account_uuid' => $account->getUuid(),
                'type' => TypeEnum::BONUS->value,
            ])) {
                $repAmount = floor($wallet->getAmount());
                $resp = $wallet->getAmount() - $repAmount;

                if ($resp >= 0) {
                    $replenishment->setBonusWalletUuid($wallet->getUuid());
                    $replenishment->setBonusAmount($repAmount);

                    $this->walletService->update([
                        'uuid' => $wallet->getUuid(),
                    ], [
                        'amount' => $resp,
                    ]);

                    $dto->setBonus($wallet);
                    $dto->setReplenishment($replenishment);
                }
            }
        }

        return $next($dto);
    }
}
