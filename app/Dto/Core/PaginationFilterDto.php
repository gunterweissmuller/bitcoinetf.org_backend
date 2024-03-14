<?php

declare(strict_types=1);

namespace App\Dto\Core;

use App\Dto\DtoInterface;

final class PaginationFilterDto implements DtoInterface
{
    public function __construct(
        private ?array $filters,
        private ?int $page,
        private ?int $perPage,
        private string|null $orderColumn,
        private string|null $orderBy,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            $args['filters'] ?? null,
            $args['page'] ?? null,
            $args['per_page'] ?? null,
            $args['order_column'] ?? null,
            $args['order_by'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'filters' => $this->filters,
            'page' => $this->page,
            'per_page' => $this->perPage,
            'order_column' => $this->orderColumn,
            'order_by' => $this->orderBy,
        ];
    }

    /**
     * @return array|null
     */
    public function getFilters(): ?array
    {
        return $this->filters;
    }

    /**
     * @param  array|null  $filters
     */
    public function setFilters(?array $filters): void
    {
        $this->filters = $filters;
    }

    /**
     * @return int|null
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @param  int|null  $page
     */
    public function setPage(?int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int|null
     */
    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    /**
     * @param  int|null  $perPage
     */
    public function setPerPage(?int $perPage): void
    {
        $this->perPage = $perPage;
    }

    public function getOrderColumn(): ?string
    {
        return $this->orderColumn;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }
}
