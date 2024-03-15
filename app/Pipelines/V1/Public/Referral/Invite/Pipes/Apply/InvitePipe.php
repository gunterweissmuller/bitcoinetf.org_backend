<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Referral\Invite\Pipes\Apply;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Referral\Invite\ApplyPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Referrals\InviteService;
use Closure;

final readonly class InvitePipe implements PipeInterface
{
    public function __construct(
        private InviteService $inviteService,
    ) {
    }

    public function handle(ApplyPipelineDto|DtoInterface $dto, Closure $next): DtoInterface
    {
        $invite = $dto->getInvite();
        $invite->setCodeUuid($dto->getCode()->getUuid());

        $this->inviteService->create($invite);

        return $next($dto);
    }
}
