<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Code\Pipes\Resend;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Code\ResendPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;

final class AccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService
    ) {
    }

    public function handle(ResendPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($account = $this->accountService->get(['uuid' => $dto->getEmail()->getAccountUuid()])) {
            $dto->setAccount($account);
        }

        return $next($dto);
    }
}
