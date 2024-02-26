<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Enums\Billing\Payment\DescTypeEnum;
use App\Enums\Billing\Payment\TypeEnum;
use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Enums\Settings\Global\SymbolEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Settings\GlobalService;
use Closure;

final class BonusPipe implements PipeInterface
{
    public function __construct(
        private readonly WalletService $walletService,
        private readonly PaymentService $paymentService,
        private readonly GlobalService $globalService,
        private readonly TokenService $tokenService,
    ) {
    }

    public function handle(InitMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();
        $invite = $dto->getInvite();

        $walletBonus = $this->walletService->get([
            'account_uuid' => $account->getUuid(),
            'type' => WalletTypeEnum::BONUS->value,
        ]);

        if ($dto->getIsExistsEmail() || $dto->getIsExistsWallet()) {
            $this->paymentService->delete([
                'account_uuid' => $account->getUuid(),
                'bonus_wallet_uuid' => $walletBonus->getUuid(),
            ]);

            $this->walletService->update([
                'account_uuid' => $account->getUuid(),
                'type' => WalletTypeEnum::BONUS->value,
            ], [
                'amount' => 0,
            ]);
        }

        $descType = DescTypeEnum::WELCOME_BONUS->value;
        $bonusAmount = $this->globalService->get(['symbol' => SymbolEnum::WELCOME_BONUS->value])->getValue();

        if ($invite) {
            $welcomeRefBonus = $this->globalService->get(['symbol' => SymbolEnum::WELCOME_REF_BONUS->value])->getValue();
            if ($welcomeRefBonus > 0) {
                $descType = DescTypeEnum::WELCOME_BONUS_REF->value;
            }

            $bonusAmount = $bonusAmount + $welcomeRefBonus;
        }

        $btcAmount = $this->tokenService->getBitcoinAmount();

        $this->paymentService->create(PaymentDto::fromArray([
            'account_uuid' => $account->getUuid(),
            'bonus_wallet_uuid' => $walletBonus->getUuid(),
            'bonus_amount' => $bonusAmount,
            'type' => TypeEnum::DEBIT_TO_CLIENT->value,
            'real_amount' => $bonusAmount,
            'total_amount_btc' => 1 / $btcAmount * $bonusAmount,
            'btc_price' => $btcAmount,
            'desc_type' => $descType,
        ]));

        $this->walletService->update([
            'account_uuid' => $account->getUuid(),
            'type' => WalletTypeEnum::BONUS->value,
        ], [
            'amount' => $bonusAmount,
        ]);

        return $next($dto);
    }
}
