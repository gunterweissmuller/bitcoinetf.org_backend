<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Kyc\Screen;

use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\AllPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\GetPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\SavePipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Public\Kyc\Screen\Pipes\All\ScreenPipe as AllScreenPipe;
use App\Pipelines\V1\Public\Kyc\Screen\Pipes\Get\ScreenPipe as GetScreenPipe;
use App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save\ScreenCurrentPipe as SaveScreenLastPipe;
use App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save\ScreenPipe as SaveScreenPipe;
use App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save\SessionFilePipe as SaveSessionFilePipe;
use App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save\SessionPipe as SaveSessionPipe;
use App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save\SessionResultPipe as SaveSessionResultPipe;
use App\Pipelines\V1\Public\Kyc\Screen\Pipes\Save\ValidationPipe as SaveValidationPipe;

final class ScreenPipeline extends AbstractPipeline
{
    public function all(AllPipelineDto $dto): array
    {
        return $this->pipeline([
            AllScreenPipe::class,
        ], $dto);
    }

    public function get(GetPipelineDto $dto): array
    {
        return $this->pipeline([
            GetScreenPipe::class,
        ], $dto);
    }

    public function save(SavePipelineDto $dto): array
    {
        return $this->pipeline([
            SaveValidationPipe::class,
            SaveScreenPipe::class,
            SaveSessionPipe::class,
            SaveSessionFilePipe::class,
            SaveSessionResultPipe::class,
            SaveScreenLastPipe::class,
        ], $dto);
    }
}
