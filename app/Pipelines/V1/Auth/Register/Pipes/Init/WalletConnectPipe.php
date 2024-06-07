<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitWalletConnectPipelineDto;
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
     * @param InitWalletConnectPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(InitWalletConnectPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if (!$walletConnect = $this->walletConnectService->get([
            'address' => $dto->getWalletConnect()->getAddress(),
        ])) {
            $walletConnect = $dto->getWalletConnect();
            $walletConnect->setAccountUuid($dto->getAccount()->getUuid());
            $walletConnect->setStatus(StatusEnum::AwaitConfirm->value);
            $walletConnect->setAddress($dto->getWalletConnect()->getAddress());

            $walletConnect = $this->walletConnectService->create($walletConnect);
        }

        $dto->setWalletConnect($walletConnect);
        return $next($dto);
    }
}
