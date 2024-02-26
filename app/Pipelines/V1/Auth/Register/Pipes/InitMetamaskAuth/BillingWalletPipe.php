<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\WalletDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WalletService;
use Closure;

final class BillingWalletPipe implements PipeInterface
{
    public function __construct(
        private readonly WalletService $walletService,
    ) {
    }

    public function handle(InitMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();

        if (!$dto->getIsExistsEmail() && !$dto->getIsExistsWallet()) {
            $this->walletService->create(WalletDto::fromArray([
                'account_uuid' => $account->getUuid(),
                'type' => WalletTypeEnum::VAULT->value,
                'amount' => 0.0,
            ]));

            $this->walletService->create(WalletDto::fromArray([
                'account_uuid' => $account->getUuid(),
                'type' => WalletTypeEnum::REFERRAL->value,
                'amount' => 0.0,
            ]));

            $this->walletService->create(WalletDto::fromArray([
                'account_uuid' => $account->getUuid(),
                'type' => WalletTypeEnum::BONUS->value,
                'amount' => 0.0,
            ]));

            $this->walletService->create(WalletDto::fromArray([
                'account_uuid' => $account->getUuid(),
                'type' => WalletTypeEnum::DIVIDENDS->value,
                'amount' => 0.0,
            ]));
        }

        return $next($dto);
    }
}
