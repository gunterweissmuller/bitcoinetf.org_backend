<?php

declare(strict_types=1);

namespace App\Pipelines\V1\Private\Pages\SectionTemplate\Pipes\Update;

use App\Dto\DtoInterface;
use App\Dto\Pipelines\Api\V1\Private\Pages\Section\SectionTemplatePipelineDto;
use App\Exceptions\Core\NotFoundException as SectionExistsException;
use App\Pipelines\PipeInterface;
use App\Services\Api\V1\Pages\SectionTemplateService;
use Closure;

final class SectionPipe implements PipeInterface
{
    public function __construct(private SectionTemplateService $sectionService)
    {
    }

    public function handle(DtoInterface|SectionTemplatePipelineDto $dto, Closure $next): DtoInterface
    {
        $section = $dto->getSectionTemplate();

        if (!is_null($section->getData())) {
            if (!$this->sectionService->get([
                ['id', $section->getId()],
            ])) {
                throw new SectionExistsException();
            }

            $data = $section->toArray();
            unset($data['files']);

            $this->sectionService->update([
                'id' => $section->getId(),
            ], $data);
        }

        return $next($dto);
    }
}
