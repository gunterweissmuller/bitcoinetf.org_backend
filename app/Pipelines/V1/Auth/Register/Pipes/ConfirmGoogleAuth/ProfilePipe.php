<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\ConfirmGoogleAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmGooglePipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\ProfileService;
use Closure;

final class ProfilePipe implements PipeInterface
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {
    }

    public function handle(ConfirmGooglePipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $this->profileService->update([
            'account_uuid' => $dto->getAccount()->getUuid(),
        ], [
            'full_name' => $dto->getProfile()->getFullName(),
        ]);

        return $next($dto);
    }
}
