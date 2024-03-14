<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Storage\File;

use App\Dto\Pipelines\Api\V1\Public\Storage\File\UploadPipelineDto;
use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Public\Storage\File\Pipes\FilePipe;
use App\Pipelines\V1\Public\Storage\File\Pipes\S3Pipe;

final class FilePipeline extends AbstractPipeline
{
    public function upload(UploadPipelineDto $dto): array
    {
        return $this->pipeline([
            S3Pipe::class,
            FilePipe::class,
        ], $dto);
    }
}
