<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\Init;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitApplePipelineDto;
use App\Enums\Users\AppleAccount\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AppleAccountService;
use Closure;

final class AppleAccountPipe implements PipeInterface
{
    public function __construct(
        private readonly AppleAccountService $appleAccountService,
    ) {
    }

    public function handle(InitApplePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if (!$appleAccount = $this->appleAccountService->get(['apple_id' => $dto->getAppleAccount()->getAppleId()])) {
            $appleAccount = $dto->getAppleAccount();
            $appleAccount->setAccountUuid($dto->getAccount()->getUuid());
            $appleAccount->setStatus(StatusEnum::AwaitConfirm->value);
            $appleAccount->setAppleId($dto->getAppleAccount()->getAppleId());

            $appleAccount = $this->appleAccountService->create($appleAccount);
        }

        $dto->setAppleAccount($appleAccount);
        return $next($dto);
    }
}
