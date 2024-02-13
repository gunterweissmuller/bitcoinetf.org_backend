<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Create;

use Closure;
use App\Dto\DtoInterface;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Pages\SectionTemplateService;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionTemplatePipelineDto;

final class SectionPipe implements PipeInterface
{
    public function __construct(private SectionTemplateService $sectionService) {}

    public function handle(DtoInterface|SectionTemplatePipelineDto $dto, Closure $next): DtoInterface
    {
        $dto->setSectionTemplate($this->sectionService->create($dto->getSectionTemplate()));

        return $next($dto);
    }
}
