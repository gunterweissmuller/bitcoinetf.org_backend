<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Users\Account\Pipes\Create;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Private\Users\Account\CreatePipelineDto;
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

    public function handle(DtoInterface|CreatePipelineDto $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();
        $account->setStatus($account->getStatus() ?? StatusEnum::Enabled->value);

        $dto->setAccount($this->accountService->create($account));

        return $next($dto);
    }
}
