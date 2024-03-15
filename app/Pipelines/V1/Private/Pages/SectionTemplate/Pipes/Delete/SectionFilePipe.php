<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Delete;

use Closure;
use App\Dto\DtoInterface;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Pages\SectionTemplateFileService;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionTemplatePipelineDto;

final class SectionFilePipe implements PipeInterface
{
    public function __construct(private SectionTemplateFileService $sectionFileService) {}

    public function handle(DtoInterface|SectionTemplatePipelineDto $dto, Closure $next): DtoInterface
    {
        $this->sectionFileService->delete(['section_template_id' => $dto->getSectionTemplate()->getId()]);

        return $next($dto);
    }
}
