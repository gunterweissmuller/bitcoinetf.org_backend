<?php

declare(strict_types=1);

namespace App\Dto\Models\Pages;

use App\Dto\DtoInterface;

final class SectionFileDto implements DtoInterface
{
    public function __construct(
        private int|null    $sectionId,
        private string|null $fileUuid,
        private string|null $createdAt
    )
    {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['section_id'] ?? null,
            $args['file_uuid'] ?? null,
            $args['created_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'section_id' => $this->sectionId,
            'file_uuid' => $this->fileUuid,
            'created_at' => $this->createdAt,
        ];
    }

    public function getSectionId(): ?int
    {
        return $this->sectionId;
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
