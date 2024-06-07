<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ConfirmAppleAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmApplePipelineDto;
use App\Enums\Users\AppleAccount\StatusEnum;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\AppleAccountService;
use Closure;

final class ApplePipe implements PipeInterface
{
    public function __construct(
        private readonly AppleAccountService $appleAccountService,
    )
    {
    }

    public function handle(ConfirmApplePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($appleAccount = $this->appleAccountService->get(['apple_id' => $dto->getAppleAccount()->getAppleId()])) {
            $appleAccount->setStatus(StatusEnum::Enabled->value);

            $this->appleAccountService->update([
                'apple_id' => $appleAccount->getAppleId(),
            ], [
                'status' => $appleAccount->getStatus(),
            ]);
            $dto->setAppleAccount($appleAccount);
        }

        return $next($dto);
    }
}
