<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Public\Storage\File\Pipes;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Public\Storage\File\UploadPipelineDto;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Storage\FileService;
use Closure;

final class FilePipe implements PipeInterface
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function handle(DtoInterface|UploadPipelineDto $dto, Closure $next): DtoInterface
    {
        $dto->setFile($this->fileService->create($dto->getFile()));

        return $next($dto);
    }
}
