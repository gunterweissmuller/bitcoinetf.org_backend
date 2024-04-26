<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\LoginOneTimePass;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginOneTimePasswordPipelineDto;
use App\Enums\Auth\Code\TypeEnum;
use App\Enums\Users\Account\StatusEnum;
use \App\Enums\Auth\Code\StatusEnum as CodeStatusEnum;
use App\Exceptions\Pipelines\V1\Auth\IncorrectLoginDataException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Auth\CodeService;
use App\Services\Api\V1\Users\AccountService;
use Closure;

final class AccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AccountService $accountService,
        private readonly CodeService    $codeService,
    )
    {
    }

    /**
     * @param LoginOneTimePasswordPipelineDto|DtoInterface $dto
     * @param Closure $next
     * @return DtoInterface
     */
    public function handle(LoginOneTimePasswordPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($account = $this->accountService->get([
            'uuid' => $dto->getEmail()->getAccountUuid(),
            'status' => StatusEnum::Enabled->value,
        ])) {
            if (!$this->codeService->get([
                'code' => $dto->getCode()->getCode(),
                'type' => TypeEnum::OneTimePassword->value,
                'status' => CodeStatusEnum::Unused->value,
            ])) {
                throw new IncorrectLoginDataException();
            }

            $dto->setAccount($account);
        } else {
            throw new IncorrectLoginDataException();
        }

        return $next($dto);
    }
}
