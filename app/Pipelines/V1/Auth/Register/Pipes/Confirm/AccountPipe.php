<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Enums\Users\Account\ProviderTypeEnum;
use App\Enums\Users\Account\StatusEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectPasswordException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;
use Illuminate\Support\Facades\Hash;

final class AccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService,
    )
    {
    }

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($account = $this->accountService->get(['uuid' => $dto->getEmail()->getAccountUuid()])) {
            $account->setStatus(StatusEnum::Enabled->value);

            if ($dto->isFast()) {
                $account->setFastReg(true);
            } else {
                $account->setFastReg(false);
            }

            if (!Hash::check($dto->getAccount()->getPassword(), $account->getPassword())) {
                throw new IncorrectPasswordException();
            }

            $account->setProviderType(ProviderTypeEnum::Email->value);

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
