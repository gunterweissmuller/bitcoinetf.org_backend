<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Auth\AuthType;


use App\Dto\Pipelines\Api\V1\Auth\AuthType\AuthTypeFacebookPipelineDto;
use App\Dto\Pipelines\Api\V1\Auth\AuthType\AuthTypeTelegramPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Auth\AuthType\Pipes\CheckFacebook\ValidatePipe as CheckFacebookValidatePipe;
use App\Pipelines\V1\Auth\AuthType\Pipes\CheckTelegram\ValidatePipe as CheckTelegramValidatePipe;

final class AuthTypePipeline extends AbstractPipeline
{
    public function checkTelegram(AuthTypeTelegramPipelineDto $dto): array
    {
        return $this->pipeline([
            CheckTelegramValidatePipe::class,
        ], $dto);
    }

    public function checkFacebook(AuthTypeFacebookPipelineDto $dto): array
    {
        return $this->pipeline([
            CheckFacebookValidatePipe::class,
        ], $dto);
    }
}
