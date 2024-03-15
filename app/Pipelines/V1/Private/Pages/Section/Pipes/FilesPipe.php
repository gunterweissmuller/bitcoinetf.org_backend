<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\Section\Pipes;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionPipelineDto;
use App\Enums\Storage\File\StatusEnum as FileStatusesEnum;
use App\Exceptions\Core\NotFoundException as FilesExistsException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Storage\FileService;
use Closure;

final class FilesPipe implements PipeInterface
{
    private FileService $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function handle(DtoInterface|SectionPipelineDto $dto, Closure $next): DtoInterface
    {
        if ($filesUuids = $dto->getFilesUuids()) {
            $files = $this->service->list([], (function ($query) use ($dto, $filesUuids) {
                return $query->whereIn('uuid', $filesUuids)
                    ->whereIn('status', [
                        FileStatusesEnum::Active->value,
                    ]);
            }));

            if (is_null($files)) {
                throw new FilesExistsException();
            }

            $dto->setFilesUuids($files->toArray());
        }

        return $next($dto);
    }
}
