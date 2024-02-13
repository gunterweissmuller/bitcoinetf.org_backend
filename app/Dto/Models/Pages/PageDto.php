<?php

declare(strict_types=1);

namespace App\Dto\Models\Pages;

use App\Dto\DtoInterface;

final class PageDto implements DtoInterface
{
    public function __construct(
        private int|null $id,
        private string|null $name,
        private string|null $slug,
        private string|null $status,
        private string|null $createdAt,
        private string|null $updatedAt
    )
    {
    }

    public static function fromArray(array $arguments): DtoInterface|self
    {
        return new self(
            $arguments['id'] ?? null,
            $arguments['name'] ?? null,
            $arguments['slug'] ?? null,
            $arguments['status'] ?? null,
            $arguments['created_at'] ?? null,
            $arguments['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
}
