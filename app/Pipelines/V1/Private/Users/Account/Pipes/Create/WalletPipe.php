<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Users\Account\Pipes\Create;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\WalletDto;
use App\Dto\Pipelines\Api\V1\Private\Users\Account\CreatePipelineDto;
use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Billing\WalletService;
use Closure;

final class WalletPipe implements PipeInterface
{
    public function __construct(
        private readonly WalletService $walletService,
    ) {
    }

    public function handle(DtoInterface|CreatePipelineDto $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();

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

        return $next($dto);
    }
}
