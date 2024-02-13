<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Referral\Invite;

use App\Dto\Pipelines\Api\V1\Public\Referral\Invite\ApplyPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Public\Referral\Invite\Pipes\Apply\CodePipe as ApplyCodePipe;
use App\Pipelines\V1\Public\Referral\Invite\Pipes\Apply\CodeUsedPipe as ApplyCodeUsedPipe;
use App\Pipelines\V1\Public\Referral\Invite\Pipes\Apply\InvitePipe as ApplyInvitePipe;

final class InvitePipeline extends AbstractPipeline
{
    public function apply(ApplyPipelineDto $dto): array
    {
        return $this->pipeline([
            ApplyCodeUsedPipe::class,
            ApplyCodePipe::class,
            ApplyInvitePipe::class,
        ], $dto);
    }
}
