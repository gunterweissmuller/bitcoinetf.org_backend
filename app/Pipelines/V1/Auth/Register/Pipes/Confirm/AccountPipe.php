<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Enums\Users\Account\StatusEnum;
use App\Jobs\V1\Auth\SendPasswordMailJob;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class AccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($account = $this->accountService->get(['uuid' => $dto->getEmail()->getAccountUuid()])) {
            $account->setStatus(StatusEnum::Enabled->value);

            if ($dto->isFast()) {
                $randomPassword = Str::random();
                $account->setPassword(Hash::make($randomPassword));
                $account->setFastReg(true);
                dispatch(new SendPasswordMailJob($account->getUuid(), $dto->getEmail()->getEmail(), $randomPassword));
            } else {
                $account->setFastReg(false);
                $account->setPassword(Hash::make($dto->getAccount()->getPassword()));
            }

            $this->accountService->update([
                'uuid' => $account->getUuid(),
            ], [
                'status' => $account->getStatus(),
                'password' => $account->getPassword(),
                'fast_reg' => $account->getFastReg(),
            ]);

            $dto->setAccount($account);
        }

        return $next($dto);
    }
}
