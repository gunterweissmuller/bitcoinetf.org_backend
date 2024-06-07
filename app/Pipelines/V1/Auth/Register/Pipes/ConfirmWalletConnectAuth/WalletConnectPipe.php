<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ConfirmWalletConnectAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmWalletConnectPipelineDto;
use App\Enums\Users\WalletConnect\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\WalletConnectService;
use Closure;

final class WalletConnectPipe implements PipeInterface
{
    /**
     * @param WalletConnectService $walletConnectService
     */
    public function __construct(
        private readonly WalletConnectService $walletConnectService,
    )
    {
    }

    /**
     * @param ConfirmWalletConnectPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(ConfirmWalletConnectPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($walletConnect = $this->walletConnectService->get(['address' => $dto->getWalletConnect()->getAddress()])) {
            $walletConnect->setStatus(StatusEnum::Enabled->value);

            $this->walletConnectService->update([
                'address' => $walletConnect->getAddress(),
            ], [
                'status' => $walletConnect->getStatus(),
            ]);
            $dto->setWalletConnect($walletConnect);
        }

        return $next($dto);
    }
}
