<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Billing\Withdrawal\Pipes\Dividends;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
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

    public function handle(DividendPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $wallet = $dto->getWallet();
        $btcPrice = $this->tokenService->getBitcoinAmount();

        $dto->setPayment(
            $this->paymentService->create(PaymentDto::fromArray([
                'account_uuid' => $wallet->getAccountUuid(),
                'type' => TypeEnum::WITHDRAWAL->value,
                'dividend_wallet_uuid' => $wallet->getUuid(),
                'dividend_amount' => $wallet->getBtcAmount() * $btcPrice,
                'total_amount_btc' => $wallet->getBtcAmount(),
                'btc_price' => $btcPrice,
                'withdrawal_method' => $dto->getMethod(),
            ]))
        );

        $wallet->setAmount(0);
        $wallet->setBtcAmount(0);
        $dto->setWallet($wallet);

        $this->walletService->update([
            'uuid' => $wallet->getUuid(),
        ], [
            'amount' => $wallet->getAmount(),
            'btc_amount' => $wallet->getBtcAmount(),
        ]);

        return $next($dto);
    }
}
