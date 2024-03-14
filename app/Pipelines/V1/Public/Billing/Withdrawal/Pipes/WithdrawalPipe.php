<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\WithdrawalDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Enums\Billing\Withdrawal\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WithdrawalService;
use Closure;

final readonly class WithdrawalPipe implements PipeInterface
{
    public function __construct(
        private WithdrawalService $withdrawalService,
    ) {
    }

    public function handle(DividendPipelineDto|ReferralPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $wallet = $dto->getWallet();
        $payment = $dto->getPayment();

        $dto->setWithdrawal($this->withdrawalService->create(
            WithdrawalDto::fromArray([
                'account_uuid' => $payment->getAccountUuid(),
                'referral_wallet_uuid' => $payment->getReferralWalletUuid(),
                'dividend_wallet_uuid' => $payment->getDividendWalletUuid(),
                'referral_amount' => $payment->getReferralAmount(),
                'dividend_amount' => $payment->getDividendAmount(),
                'total_amount' => $payment->getTotalAmount(),
                'total_amount_btc' => $payment->getTotalAmountBtc(),
                'btc_price' => $payment->getBtcPrice(),
                'wallet_address' => $wallet->getWithdrawalAddress(),
                'status' => StatusEnum::PENDING->value,
            ])
        ));
        
        return $next($dto);
    }
}
