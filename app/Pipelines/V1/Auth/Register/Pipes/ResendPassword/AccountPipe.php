<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ResendPassword;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ResendPasswordPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AccountService;
use Closure;

final class AccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService
    )
    {
    }

    /**
     * @param ResendPasswordPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(ResendPasswordPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($account = $this->accountService->get(['uuid' => $dto->getEmail()->getAccountUuid()])) {
            $dto->setAccount($account);
        }

        return $next($dto);
    }
}
