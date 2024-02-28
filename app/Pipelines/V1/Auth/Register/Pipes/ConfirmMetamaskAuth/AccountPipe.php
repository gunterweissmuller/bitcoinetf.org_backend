<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ConfirmMetamaskAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmMetamaskPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Enums\Users\Account\ProviderTypeEnum;
use App\Enums\Users\Account\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;

final class AccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    public function handle(ConfirmMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($account = $this->accountService->get(['uuid' => $dto->getEmail()->getAccountUuid()])) {
            $account->setStatus(StatusEnum::Enabled->value);
            $account->setProviderType(ProviderTypeEnum::Metamask->value);
            $account->setFastReg(false);

            $this->accountService->update([
                'uuid' => $account->getUuid(),
            ], [
                'status' => $account->getStatus(),
                'fast_reg' => $account->getFastReg(),
                'provider_type' => $account->getProviderType(),
            ]);

            $dto->setAccount($account);
        }

        return $next($dto);
    }
}
