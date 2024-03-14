<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\LoginMetamask;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginMetamaskPipelineDto;
use App\Enums\Users\Account\ProviderTypeEnum;
use App\Enums\Users\Account\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectLoginDataException;
use App\Exceptions\Pipelines\V1\Auth\IncorrectLoginProviderTypeException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;

final class AccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    public function handle(LoginMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($account = $this->accountService->get([
            'uuid' => $dto->getWallet()->getAccountUuid(),
            'status' => StatusEnum::Enabled->value,
        ])) {
            if ($account->getProviderType() !== ProviderTypeEnum::Metamask->value) {
                throw new IncorrectLoginProviderTypeException();
            }
            $dto->setAccount($account);
        } else {
            throw new IncorrectLoginDataException();
        }

        return $next($dto);
    }
}
