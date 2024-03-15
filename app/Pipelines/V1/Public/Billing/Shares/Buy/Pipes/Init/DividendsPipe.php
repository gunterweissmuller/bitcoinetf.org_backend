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
                if ($wallet->getBtcAmount() <= 0) {
                    return $next($dto);
                }

                $btcPrice = $replenishment->getBtcPrice();
                $dividendAmount = $btcPrice * $wallet->getBtcAmount();
                $dividendAmountFloor = floor($btcPrice * $wallet->getBtcAmount());
                $dividendAmountResp = $dividendAmount - $dividendAmountFloor;

                $replenishment->setDividendWalletUuid($wallet->getUuid());
                $replenishment->setDividendAmount($dividendAmountFloor);
                $replenishment->setDividendBtcAmount($wallet->getBtcAmount());
                $replenishment->setDividendUsdtAmount($wallet->getAmount());
                $replenishment->setDividendRespAmount($dividendAmountResp > 0 ? $dividendAmountResp : null);

                $this->walletService->update([
                    'uuid' => $wallet->getUuid(),
                ], [
                    'amount' => 0,
                    'btc_amount' => 0,
                ]);

                $dto->setDividends($wallet);
                $dto->setReplenishment($replenishment);
            }
        }

        return $next($dto);
    }
}
