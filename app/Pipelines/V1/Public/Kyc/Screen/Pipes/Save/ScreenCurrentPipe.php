<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\SavePipelineDto;
use App\Enums\Billing\Payment\DescTypeEnum;
use App\Enums\Billing\Payment\TypeEnum;
use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Enums\Kyc\Session\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Kyc\ScreenService;
use App\Services\Api\V1\Kyc\SessionService;
use App\Services\Api\V1\Settings\GlobalService;
use Closure;

final class ScreenCurrentPipe implements PipeInterface
{
    public function __construct(
        private readonly ScreenService $screenService,
        private readonly SessionService $sessionService,
        private readonly WalletService $walletService,
        private readonly PaymentService $paymentService,
        private readonly GlobalService $globalService,
        private readonly TokenService $tokenService,
    ) {
    }

    public function handle(SavePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $session = $dto->getSession();
        $screen = $dto->getScreen();
        $currentScreen = $this->screenService->get([
            'form_uuid' => $screen->getFormUuid(),
            ['sort', '>', $screen->getSort()],
        ]);

        $this->sessionService->update([
            'uuid' => $session->getUuid(),
        ], [
            'status' => $currentScreen
                ? StatusEnum::InProcess->value
                : StatusEnum::Passed->value,
            'current_screen_uuid' => $currentScreen?->getUuid(),
        ]);

        //KYC bonus
        /*if (is_null($currentScreen)) {
            $btcPrice = $this->tokenService->getBitcoinAmount();
            $kycBonus = $this->globalService->getKycBonusValue();

            $wallet = $this->walletService->get([
                'account_uuid' => $session->getAccountUuid(),
                'type' => WalletTypeEnum::BONUS->value,
            ]);

            $this->walletService->update([
                'uuid' => $wallet->getUuid(),
            ], [
                'amount' => $wallet->getAmount() + $kycBonus,
            ]);

            $this->paymentService->create(PaymentDto::fromArray([
                'account_uuid' => $wallet->getAccountUuid(),
                'bonus_wallet_uuid' => $wallet->getUuid(),
                'bonus_amount' => $kycBonus,
                'type' => TypeEnum::DEBIT_TO_CLIENT->value,
                'total_amount_btc' => (float) bcmul(
                    bcdiv(
                        '1',
                        (string) $btcPrice,
                        8,
                    ),
                    (string) $kycBonus,
                    8,
                ),
                'btc_price' => $btcPrice,
                'desc_type' => DescTypeEnum::KYC_BONUS->value,
            ]));
        }*/

        return $next($dto);
    }
}
