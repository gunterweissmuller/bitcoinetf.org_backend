<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Update;

use Closure;
use App\Dto\DtoInterface;
use App\Pipelines\PipeInterface;
use App\Dto\Models\Storage\FileDto;
use App\Dto\Models\Pages\SectionTemplateFileDto;
use App\Services\Api\V1\Pages\SectionTemplateFileService;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionTemplatePipelineDto;

final class SectionFilePipe implements PipeInterface
{
    private SectionTemplateFileService $sectionFileService;

    public function __construct(SectionTemplateFileService $sectionFileService)
    {
        $this->sectionFileService = $sectionFileService;
    }

    public function handle(DtoInterface|SectionTemplatePipelineDto $dto, Closure $next): DtoInterface
    {
        if ($files = $dto->getFilesUuids()) {
            $sectionId = $dto->getSectionTemplate()->getId();

            $this->sectionFileService->delete(['section_template_id' => $sectionId]);

            /* @var FileDto $file */
            foreach ($files as $file) {
                $this->sectionFileService->create(SectionTemplateFileDto::fromArray([
                    'section_template_id' => $sectionId,
                    'file_uuid' => $file->getUuid(),
                ]));
            }
        }

        return $next($dto);
    }
}
