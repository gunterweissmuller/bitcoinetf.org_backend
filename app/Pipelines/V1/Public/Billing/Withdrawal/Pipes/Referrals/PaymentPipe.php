<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Referrals;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralPipelineDto;
use App\Enums\Billing\Payment\TypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Billing\WalletService;
use Closure;

final readonly class PaymentPipe implements PipeInterface
{
    public function __construct(
        private TokenService $tokenService,
        private PaymentService $paymentService,
        private WalletService $walletService,
    ) {
    }

    public function handle(ReferralPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $wallet = $dto->getWallet();
        $btcPrice = $this->tokenService->getBitcoinAmount();

        $dto->setPayment(
            $this->paymentService->create(PaymentDto::fromArray([
                'account_uuid' => $wallet->getAccountUuid(),
                'type' => TypeEnum::WITHDRAWAL->value,
                'referral_wallet_uuid' => $wallet->getUuid(),
                'referral_amount' => $wallet->getAmount(),
                'total_amount_btc' => 1 / $btcPrice * $wallet->getAmount(),
                'btc_price' => $btcPrice,
            ]))
        );

        $wallet->setAmount(0);
        $dto->setWallet($wallet);

        $this->walletService->update([
            'uuid' => $wallet->getUuid(),
        ], [
            'amount' => $wallet->getAmount(),
        ]);

        return $next($dto);
    }
}
