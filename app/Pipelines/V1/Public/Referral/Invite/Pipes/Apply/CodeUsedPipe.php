<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Referral\Invite\Pipes\Apply;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Referral\Invite\ApplyPipelineDto;
use App\Exceptions\Pipelines\V1\Referral\AlreadyUsedCodeException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Referrals\InviteService;
use Closure;

final readonly class CodeUsedPipe implements PipeInterface
{
    public function __construct(
        private InviteService $inviteService,
    ) {
    }

    public function handle(ApplyPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        if ($this->inviteService->get(['account_uuid' => $dto->getInvite()->getAccountUuid()])) {
            throw new AlreadyUsedCodeException();
        }

        return $next($dto);
    }
}
