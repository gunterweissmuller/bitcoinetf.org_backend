<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\LoginWalletConnect;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginWalletConnectPipelineDto;
use App\Enums\Users\Account\ProviderTypeEnum;
use App\Enums\Users\Account\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectLoginDataException;
use App\Exceptions\Pipelines\V1\Auth\IncorrectLoginProviderTypeException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;

final class AccountPipe implements PipeInterface
{
    /**
     * @param AccountService $accountService
     */
    public function __construct(
        private readonly AccountService $accountService,
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
        if ($account = $this->accountService->get([
            'uuid' => $dto->getWalletConnect()->getAccountUuid(),
            'status' => StatusEnum::Enabled->value,
        ])) {
            if ($account->getProviderType() !== ProviderTypeEnum::WalletConnect->value) {
                throw new IncorrectLoginProviderTypeException();
            }
            $dto->setAccount($account);
        } else {
            throw new IncorrectLoginDataException();
        }

        return $next($dto);
    }
}
