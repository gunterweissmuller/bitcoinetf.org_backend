<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Private\Pages\Section;

use App\Dto\DtoInterface;
use App\Dto\Models\Pages\SectionTemplateDto;

final class SectionTemplatePipelineDto implements DtoInterface
{
    private SectionTemplateDto $sectionTemplate;

    private array|null $filesUuids;

    public function __construct(
        SectionTemplateDto $sectionTemplate,
        ?array $filesUuids
    )
    {
        $this->sectionTemplate = $sectionTemplate;
        $this->filesUuids = $filesUuids;
    }

    public function toArray(): array
    {
        return [
            'section_template' => $this->sectionTemplate,
            'files_uuids' => $this->filesUuids,
        ];
    }

    public static function fromArray(array $args): DtoInterface|SectionTemplatePipelineDto
    {
        return new self(
            $args['section_template'],
            $args['files_uuids'] ?? null
        );
    }

    public function getSectionTemplate(): SectionTemplateDto
    {
        return $this->sectionTemplate;
    }

    public function setSectionTemplate(SectionTemplateDto $dto): void
    {
        $this->sectionTemplate = $dto;
    }

    public function getFilesUuids(): ?array
    {
        return $this->filesUuids;
    }

    public function setFilesUuids(?array $filesUuids): void
    {
        $this->filesUuids = $filesUuids;
    }
}
