<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Register\Pipes\InitMetamaskAuth;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Users\ProfileService;
use Closure;

final class ProfilePipe implements PipeInterface
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {
    }

    public function handle(InitMetamaskPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $account = $dto->getAccount();
        $profile = $dto->getProfile();

        if (!$dto->getIsExistsEmail() && !$dto->getIsExistsWallet()) {
            $profile->setAccountUuid($account->getUuid());
            $this->profileService->create($profile);
        } else {
            $this->profileService->update([
                'account_uuid' => $dto->getAccount()->getUuid(),
            ], [
                'full_name' => $profile->getFullName(),
            ]);
        }

        return $next($dto);
    }
}
