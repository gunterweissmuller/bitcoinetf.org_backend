<?php

declare(strict_types=1);

namespace App\Dto\Models\Pages;

use App\Dto\DtoInterface;

final class SectionTemplateFileDto implements DtoInterface
{
    public function __construct(
        private int|null    $sectionTemplateId,
        private string|null $fileUuid,
        private string|null $createdAt
    )
    {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['section_template_id'] ?? null,
            $args['file_uuid'] ?? null,
            $args['created_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'section_template_id' => $this->sectionTemplateId,
            'file_uuid' => $this->fileUuid,
            'created_at' => $this->createdAt,
        ];
    }

    public function getSectionTemplateId(): ?int
    {
        return $this->sectionTemplateId;
    }

    public function getFileUuid(): ?int
    {
        return $this->fileUuid;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
