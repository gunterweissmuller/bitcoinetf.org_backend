<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\AuthType\Pipes\CheckWalletConnect;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\AuthType\AuthTypeWalletConnectPipelineDto;
use App\Enums\Auth\AuthType\StatusEnum as AuthTypeStatusEnum;
use App\Enums\Users\WalletConnect\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\UserAlreadyExistException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\WalletConnectService;
use Closure;

final class ValidatePipe implements PipeInterface
{
    /**
     * @param WalletConnectService $walletConnectService
     */
    public function __construct(
        private readonly WalletConnectService $walletConnectService,
    ) {
    }

    /**
     * @param AuthTypeWalletConnectPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(AuthTypeWalletConnectPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $walletConnect = $this->walletConnectService->get([
            'address' => $dto->getWalletConnect()->getAddress(),
        ]);

        if (!$walletConnect) {
            $dto->setAuthType(AuthTypeStatusEnum::Registration);
        } else if ($walletConnect->getStatus() === StatusEnum::AwaitConfirm->value) {
            $dto->setAuthType(AuthTypeStatusEnum::Registration);
        } else if ($walletConnect->getStatus() === StatusEnum::Enabled->value) {
            $dto->setAuthType(AuthTypeStatusEnum::Login);
        } else {
            throw new UserAlreadyExistException();
        }

        return $next($dto);
    }
}
