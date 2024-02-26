<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\WalletService;
use Closure;
use App\Enums\Users\Wallet\StatusEnum;

final class WalletPipe implements PipeInterface
{
    public function __construct(
        private readonly WalletService $walletService,
    ) {
    }

    public function handle(InitMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if (!$dto->getIsExistsWallet()) {
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
