<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\Section\Pipes\Delete;

use Closure;
use App\Dto\DtoInterface;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Pages\SectionFileService;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionPipelineDto;

final class SectionFilePipe implements PipeInterface
{
    public function __construct(private SectionFileService $sectionFileService) {}

    public function handle(DtoInterface|SectionPipelineDto $dto, Closure $next): DtoInterface
    {
        $this->sectionFileService->delete(['section_id' => $dto->getSection()->getId()]);

        return $next($dto);
    }
}
