<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\Section\Pipes\Update;

use Closure;
use App\Dto\DtoInterface;
use App\Pipelines\PipeInterface;
use App\Dto\Models\Storage\FileDto;
use App\Dto\Models\Pages\SectionFileDto;
use App\Services\Api\V1\Pages\SectionFileService;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionPipelineDto;

final class SectionFilePipe implements PipeInterface
{
    private SectionFileService $sectionFileService;

    public function __construct(SectionFileService $sectionFileService)
    {
        $this->sectionFileService = $sectionFileService;
    }

    public function handle(DtoInterface|SectionPipelineDto $dto, Closure $next): DtoInterface
    {
        $files = $dto->getFilesUuids();

        if ($files || $files === []) {
            $sectionId = $dto->getSection()->getId();

            $this->sectionFileService->delete(['section_id' => $sectionId]);

            /* @var FileDto $file */
            foreach ($files as $file) {
                $this->sectionFileService->create(SectionFileDto::fromArray([
                    'section_id' => $sectionId,
                    'file_uuid' => $file->getUuid(),
                ]));
            }
        }

        return $next($dto);
    }
}
