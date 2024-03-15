<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Login\Pipes\LoginApple;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginApplePipelineDto;
use App\Exceptions\Pipelines\V1\Auth\IncorrectLoginDataException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AppleAccountService;
use Closure;

final class AppleAccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AppleAccountService $appleAccountService
    )
    {
    }

    public function handle(LoginApplePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($appleAccount = $this->appleAccountService->get(['apple_id' => $dto->getAppleAccount()->getAppleId()])) {
            $dto->setAppleAccount($appleAccount);
        } else {
            throw new IncorrectLoginDataException();
        }

        return $next($dto);
    }
}
