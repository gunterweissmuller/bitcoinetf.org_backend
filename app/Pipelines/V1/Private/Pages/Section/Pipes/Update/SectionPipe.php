<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\Section\Pipes\Update;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionPipelineDto;
use App\Exceptions\Core\NotFoundException as SectionExistsException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Pages\SectionService;
use Closure;

final class SectionPipe implements PipeInterface
{
    public function __construct(private SectionService $sectionService)
    {
    }

    public function handle(DtoInterface|SectionPipelineDto $dto, Closure $next): DtoInterface
    {
        $section = $dto->getSection();

        if (!is_null($section->getData())) {
            if (!$this->sectionService->get([
                ['id', $section->getId()],
                ['page_id', $section->getPageId()],
            ])) {
                throw new SectionExistsException();
            }

            $data = $section->toArray();
            unset($data['files']);

            $this->sectionService->update([
                'id' => $section->getId(),
                'page_id' => $section->getPageId(),
            ], $data);
        }

        return $next($dto);
    }
}
