<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\Recovery;

use App\Dto\Pipelines\Api\V1\Auth\Recovery\ConfirmPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\Recovery\InitPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Auth\Recovery\Pipes\Confirm\AccountPipe as ConfirmAccountPipe;
use App\Pipelines\V1\Auth\Recovery\Pipes\Confirm\CodePipe as ConfirmCodePipe;
use App\Pipelines\V1\Auth\Recovery\Pipes\Confirm\JwtPipe as ConfirmJwtPipe;
use App\Pipelines\V1\Auth\Recovery\Pipes\Init\EmailPipe as InitEmailPipe;
use App\Pipelines\V1\Auth\Recovery\Pipes\Init\EventsPipe as InitEventsPipe;

final class RecoveryPipeline extends AbstractPipeline
{
    public function init(InitPipelineDto $dto): array
    {
        return $this->pipeline([
            InitEmailPipe::class,
            InitEventsPipe::class
        ], $dto);
    }

    public function confirm(ConfirmPipelineDto $dto): array
    {
        return $this->pipeline([
            ConfirmCodePipe::class,
            ConfirmAccountPipe::class,
            ConfirmJwtPipe::class,
        ], $dto);
    }
}
