<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\PaymentDto;
use App\Dto\Models\Users\ProfileDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\SavePipelineDto;
use App\Enums\Billing\Payment\DescTypeEnum;
use App\Enums\Billing\Payment\TypeEnum;
use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\PaymentService;
use App\Services\Api\V1\Billing\TokenService;
use App\Services\Api\V1\Billing\WalletService;
use App\Services\Api\V1\Kyc\SessionResultService;
use App\Services\Api\V1\Settings\GlobalService;
use App\Services\Api\V1\Users\ProfileService;
use Closure;
use Illuminate\Support\Str;

final readonly class SessionResultPipe implements PipeInterface
{
    const SCREEN_PERSONAL_UUID = '1537519b-b637-464c-8bb3-29d2e2fa54cd';

    public function __construct(
        private SessionResultService $sessionResultService,
        private ProfileService $profileService,
        private PaymentService $paymentService,
        private WalletService $walletService,
        private GlobalService $globalService,
        private TokenService $tokenService,
    ) {
    }

    public function handle(SavePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $session = $dto->getSession();

        $sessionResultDto = $dto->getSessionResult();
        $sessionResultDto->setSessionUuid($session->getUuid());

        if (self::SCREEN_PERSONAL_UUID == $sessionResultDto->getScreenUuid()) {
            $profile = $this->profileService->get([
                'account_uuid' => $session->getAccountUuid(),
            ]) ?? ProfileDto::fromArray([
                'account_uuid' => $session->getAccountUuid(),
            ]);

            foreach ($sessionResultDto->getData() as $key => $value) {
                $method = 'set'.Str::studly($key);
                $profile->{$method}($value);
            }

            if ($this->profileService->get(['account_uuid' => $session->getAccountUuid()])) {
                $this->profileService->update([
                    'account_uuid' => $session->getAccountUuid(),
                ], $profile->toArray());
            } else {
                $this->profileService->create($profile);
            }

//            if ($profile->getCountry() === 'russia') {
//                $btcPrice = $this->tokenService->getBitcoinAmount();
//                $russiaBonus = $this->globalService->getRussiaBonusValue();
//                $wallet = $this->walletService->get([
//                    'account_uuid' => $session->getAccountUuid(),
//                    'type' => WalletTypeEnum::BONUS->value
//                ]);
//                $wallet->setAmount($wallet->getAmount() + $russiaBonus);
//                $this->walletService->update([
//                    'uuid' => $wallet->getUuid(),
//                ], [
//                    'amount' => $wallet->getAmount(),
//                ]);
//                $this->paymentService->create(PaymentDto::fromArray([
//                    'account_uuid' => $session->getAccountUuid(),
//                    'bonus_wallet_uuid' => $wallet->getUuid(),
//                    'bonus_amount' => $russiaBonus,
//                    'type' => TypeEnum::DEBIT_TO_CLIENT->value,
//                    'total_amount_btc' => 1 / $btcPrice * $russiaBonus,
//                    'btc_price' => $btcPrice,
//                    'desc_type' => DescTypeEnum::RUSSIA_BONUS->value,
//                ]));
//            }
        }

        $sessionResultDto->setData(json_encode($sessionResultDto->getData()));

        if ($sessionResult = $this->sessionResultService->get([
            'session_uuid' => $sessionResultDto->getSessionUuid(),
            'screen_uuid' => $sessionResultDto->getScreenUuid(),
        ])) {
            $this->sessionResultService->update([
                'uuid' => $sessionResult->getUuid(),
            ], [
                'data' => $sessionResult->getData(),
            ]);
        } else {
            $sessionResult = $this->sessionResultService->create($sessionResultDto);
        }

        $dto->setSessionResult($sessionResult);

        return $next($dto);
    }
}
