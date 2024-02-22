<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\LoginMetamask;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginMetamaskPipelineDto;
use App\Exceptions\Pipelines\V1\Auth\IncorrectLoginDataException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\WalletService;
use Closure;

final class WalletPipe implements PipeInterface
{
    public function __construct(
        private readonly WalletService $walletService
    )
    {
    }

    public function handle(LoginMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($wallet = $this->walletService->get(['wallet' => $dto->getWallet()->getWallet()])) {
            $dto->setWallet($wallet);
        } else {
            throw new IncorrectLoginDataException();
        }

        return $next($dto);
    }
}
