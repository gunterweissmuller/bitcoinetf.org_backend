<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Recovery\Pipes\Confirm;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Recovery\ConfirmPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;
use Illuminate\Support\Facades\Hash;

final class AccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    public function handle(ConfirmPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($account = $this->accountService->get(['uuid' => $dto->getCode()->getAccountUuid()])) {
            $account->setPassword(Hash::make($dto->getAccount()->getPassword()));

            $this->accountService->update([
                'uuid' => $account->getUuid(),
            ], [
                'password' => $account->getPassword(),
            ]);

            $dto->setAccount($account);
        }

        return $next($dto);
    }
}
