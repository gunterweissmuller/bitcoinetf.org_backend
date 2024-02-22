<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitAppleAuth;

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
        if (!$dto->getIsExists()) {
            $appleAccount = $dto->getAppleAccount();
            $appleAccount->setAccountUuid($dto->getAccount()->getUuid());
            $appleAccount->setStatus(StatusEnum::AwaitConfirm->value);

            $appleAccount = $this->appleAccountService->create($appleAccount);
        } else {
            $appleAccount = $this->appleAccountService->get(['account_uuid' => $dto->getAccount()->getUuid()]);
        }

        $dto->setAppleAccount($appleAccount);

        return $next($dto);
    }
}
