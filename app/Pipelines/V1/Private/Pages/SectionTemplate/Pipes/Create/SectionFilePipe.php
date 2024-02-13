<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Create;

use Closure;
use App\Dto\DtoInterface;
use App\Pipelines\PipeInterface;
use App\Dto\Models\Storage\FileDto;
use App\Dto\Models\Pages\SectionTemplateFileDto;
use App\Services\Api\V1\Pages\SectionTemplateFileService;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionTemplatePipelineDto;

final class SectionFilePipe implements PipeInterface
{
    public function __construct(private SectionTemplateFileService $sectionFileService) {}

    public function handle(DtoInterface|SectionTemplatePipelineDto $dto, Closure $next): DtoInterface
    {
        if ($files = $dto->getFilesUuids()) {
            /* @var FileDto $file */
            foreach ($files as $file) {
                $this->sectionFileService->create(SectionTemplateFileDto::fromArray([
                    'section_template_id' => $dto->getSectionTemplate()->getId(),
                    'file_uuid' => $file->getUuid(),
                ]));
            }
        }

        return $next($dto);
    }
}
