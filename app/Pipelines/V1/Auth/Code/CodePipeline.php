<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Code;

use App\Dto\Pipelines\Api\V1\Auth\Code\CheckPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Code\ResendPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Auth\Code\Pipes\Check\CodePipe as CheckCodePipe;
use App\Pipelines\V1\Auth\Code\Pipes\Check\EmailPipe as CheckEnrichmentPipe;
use App\Pipelines\V1\Auth\Code\Pipes\Resend\AccountPipe as ResendAccountPipe;
use App\Pipelines\V1\Auth\Code\Pipes\Resend\CodePipe as ResendCodePipe;
use App\Pipelines\V1\Auth\Code\Pipes\Resend\EmailPipe as ResendEmailPipe;
use App\Pipelines\V1\Auth\Code\Pipes\Resend\EventsPipe as ResendEventsPipe;

final class CodePipeline extends AbstractPipeline
{
    public function check(CheckPipelineDto $dto): array
    {
        return $this->pipeline([
            CheckEnrichmentPipe::class,
            CheckCodePipe::class,
        ], $dto);
    }

    public function resend(ResendPipelineDto $dto): array
    {
        return $this->pipeline([
            ResendEmailPipe::class,
            ResendAccountPipe::class,
            ResendCodePipe::class,
            ResendEventsPipe::class,
        ], $dto);
    }
}
