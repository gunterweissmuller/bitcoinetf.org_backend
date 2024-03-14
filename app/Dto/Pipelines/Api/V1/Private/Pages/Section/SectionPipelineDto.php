<?php

declare(strict_types=1);

namespace App\Dto\Pipelines\Api\V1\Private\Pages\Section;

use App\Dto\DtoInterface;
use App\Dto\Models\Pages\SectionDto;

final class SectionPipelineDto implements DtoInterface
{
    private SectionDto $section;

    private array|null $filesUuids;

    public function __construct(
        SectionDto $section,
        ?array $filesUuids
    )
    {
        $this->section = $section;
        $this->filesUuids = $filesUuids;
    }

    public function toArray(): array
    {
        return [
            'section' => $this->section,
            'files_uuids' => $this->filesUuids,
        ];
    }

    public static function fromArray(array $args): DtoInterface|SectionPipelineDto
    {
        return new self(
            $args['section'],
            $args['files_uuids'] ?? null
        );
    }

    public function getSection(): SectionDto
    {
        return $this->section;
    }

    public function setSection(SectionDto $dto): void
    {
        $this->section = $dto;
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
