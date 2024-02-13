<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Storage\File;

use App\Pipelines\AbstractPipeline;
use App\Pipelines\V1\Private\Storage\File\Pipes\S3Pipe;
use App\Dto\Pipelines\Api\V1\Private\Storage\File\UploadDto;
use App\Pipelines\V1\Private\Storage\File\Pipes\FilePipe;

final class FilePipeline extends AbstractPipeline
{
    public function upload(UploadDto $dto): array
    {
        return $this->pipeline([
            S3Pipe::class,
            FilePipe::class,
        ], $dto);
    }
}
