<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\LoginWalletConnect;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginWalletConnectPipelineDto;
use App\Enums\Users\WalletConnect\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectLoginDataException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\WalletConnectService;
use Closure;

final class WalletConnectPipe implements PipeInterface
{
    /**
     * @param WalletConnectService $walletConnectService
     */
    public function __construct(
        private readonly WalletConnectService $walletConnectService
    )
    {
    }

    /**
     * @param LoginWalletConnectPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(LoginWalletConnectPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($walletConnect = $this->walletConnectService->get([
            'address' => $dto->getWalletConnect()->getAddress(),
            'status' => StatusEnum::Enabled->value,
        ])) {
            $dto->setWalletConnect($walletConnect);
        } else {
            throw new IncorrectLoginDataException();
        }

        return $next($dto);
    }
}
