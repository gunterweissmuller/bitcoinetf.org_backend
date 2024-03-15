<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Token\Pipes\Refresh;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Token\RefreshPipelineDto;
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

    public function handle(RefreshPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($account = $this->accountService->get([
            'uuid' => $dto->getRefreshToken()->getAccountUuid(),
            'status' => StatusEnum::Enabled->value,
        ])) {
            $dto->setAccount($account);
        }

        return $next($dto);
    }
}
