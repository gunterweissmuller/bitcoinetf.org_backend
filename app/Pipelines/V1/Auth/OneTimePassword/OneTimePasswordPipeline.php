<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\OneTimePassword;

use App\Dto\Pipelines\Api\V1\Auth\OneTimePassword\InitPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\OneTimePassword\ResendPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Auth\OneTimePassword\Pipes\Init\EmailPipe as InitEmailPipe;
use App\Pipelines\V1\Auth\OneTimePassword\Pipes\Init\EventsPipe as InitEventsPipe;
use App\Pipelines\V1\Auth\OneTimePassword\Pipes\Resend\CodePipe as ResendCodePipe;
use App\Pipelines\V1\Auth\OneTimePassword\Pipes\Resend\EmailPipe as ResendEmailPipe;
use App\Pipelines\V1\Auth\OneTimePassword\Pipes\Resend\EventsPipe as ResendEventsPipe;

final class OneTimePasswordPipeline extends AbstractPipeline
{
    /**
     * @param InitPipelineDto $dto
     * @return array
     */
    public function init(InitPipelineDto $dto): array
    {
        return $this->pipeline([
            InitEmailPipe::class,
            InitEventsPipe::class
        ], $dto);
    }

    /**
     * @param ResendPipelineDto $dto
     * @return array
     */
    public function resend(ResendPipelineDto $dto): array
    {
        return $this->pipeline([
            ResendEmailPipe::class,
            ResendCodePipe::class,
            ResendEventsPipe::class
        ], $dto);
    }
}
