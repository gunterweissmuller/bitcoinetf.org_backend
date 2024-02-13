<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Storage\File\Pipes;

use Closure;
use App\Dto\DtoInterface;
use App\Pipelines\PipeInterface;
use App\Enums\Storage\File\StatusEnum;
use App\Services\Api\V1\Storage\FileService;
use App\Dto\Pipelines\Api\V1\Private\Storage\File\UploadDto;

final class FilePipe implements PipeInterface
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function handle(DtoInterface|UploadDto $dto, Closure $next): DtoInterface
    {
        $fileDto = $dto->getFile();
        $fileDto->setStatus(StatusEnum::Active->value);
        $dto->setFile($this->fileService->create($fileDto));

        return $next($dto);
    }
}
