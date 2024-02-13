<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Shares\Buy\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WalletService;
use Closure;

final readonly class DividendsPipe implements PipeInterface
{
    public function __construct(
        private WalletService $walletService,
    ) {
    }

    public function handle(InitPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();
        $replenishment = $dto->getReplenishment();

        if ($dto->getDividends() === true) {
            if ($wallet = $this->walletService->get([
                'account_uuid' => $account->getUuid(),
                'type' => TypeEnum::DIVIDENDS->value,
            ])) {
                $repAmount = floor($wallet->getAmount());
                $resp = $wallet->getAmount() - $repAmount;

                if ($resp >= 0) {
                    $replenishment->setDividendWalletUuid($wallet->getUuid());
                    $replenishment->setDividendAmount($repAmount);

                    $this->walletService->update([
                        'uuid' => $wallet->getUuid(),
                    ], [
                        'amount' => $resp,
                    ]);

                    $dto->setDividends($wallet);
                    $dto->setReplenishment($replenishment);
                }
            }
        }

        return $next($dto);
    }
}
