<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\Section\Pipes\Create;

use Closure;
use App\Dto\DtoInterface;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Pages\SectionService;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionPipelineDto;

final class SectionPipe implements PipeInterface
{
    public function __construct(private SectionService $sectionService) {}

    public function handle(DtoInterface|SectionPipelineDto $dto, Closure $next): DtoInterface
    {
        $dto->setSection($this->sectionService->create($dto->getSection()));

        return $next($dto);
    }
}
