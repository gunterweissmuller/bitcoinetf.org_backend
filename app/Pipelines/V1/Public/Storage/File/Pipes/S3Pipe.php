<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Storage\File\Pipes;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Storage\File\UploadPipelineDto;
use App\Exceptions\Pipelines\V1\Storage\FileSaveErrorException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Storage\FileService;
use Closure;
use Exception;
use Illuminate\Support\Facades\Storage;

final class S3Pipe implements PipeInterface
{
    private FileService $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function handle(DtoInterface|UploadPipelineDto $dto, Closure $next): DtoInterface
    {
        $directory = $this->service->getS3DirPath($dto->getFile()->getType());

        try {
            $path = (string)Storage::disk('s3')->put($directory, $dto->getUploadedFile(), 'public');
        } catch (Exception $exception) {
            throw new FileSaveErrorException();
        }

        $dto->getFile()->setPath($path);
        $dto->getFile()->setRealPath(Storage::disk('s3')->url($path));

        return $next($dto);
    }
}
