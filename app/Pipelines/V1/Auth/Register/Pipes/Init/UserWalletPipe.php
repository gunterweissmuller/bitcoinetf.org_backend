<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Enums\Users\Wallet\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\WalletService;
use Closure;

final class UserWalletPipe implements PipeInterface
{
    public function __construct(
        private readonly WalletService $walletService,
    ) {
    }

    public function handle(InitMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if (!$this->walletService->get([
            'wallet' => $dto->getWallet()->getWallet(),
        ])) {
            $wallet = $dto->getWallet();
            $wallet->setAccountUuid($dto->getAccount()->getUuid());
            $wallet->setStatus(StatusEnum::Verified->value);
            $wallet->setWallet($dto->getWallet()->getWallet());

            $wallet = $this->walletService->create($wallet);
        } else {
            $wallet = $this->walletService->get(['account_uuid' => $dto->getAccount()->getUuid()]);
        }

        $dto->setWallet($wallet);
        return $next($dto);
    }
}
