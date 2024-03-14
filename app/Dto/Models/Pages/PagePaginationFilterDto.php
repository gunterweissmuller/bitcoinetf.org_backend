<?php

declare(strict_types=1);

namespace App\Dto\Models\Pages;

use App\Dto\DtoInterface;

final class PagePaginationFilterDto implements DtoInterface
{
    public function __construct(
        private array|null  $filters,
        private int|null    $page,
        private int|null    $perPage,
        private string|null $slug,
    )
    {
    }

    public static function fromArray(array $arguments): DtoInterface|self
    {
        return new self(
            $arguments['filters'] ?? null,
            $arguments['page'] ?? null,
            $arguments['per_page'] ?? null,
            $arguments['slug'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'filters' => $this->filters,
            'page' => $this->page,
            'per_page' => $this->perPage,
            'slug' => $this->slug,
        ];
    }

    public function getFilters(): ?array
    {
        return $this->filters;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): void
    {
        $this->page = $page;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function setPerPage(?int $perPage): void
    {
        $this->perPage = $perPage;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
}
