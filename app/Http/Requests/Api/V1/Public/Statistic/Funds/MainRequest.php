<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Statistic\Funds;

use Illuminate\Validation\Rule;
use App\Dto\Core\PaginationFilterDto;
use App\Http\Requests\AbstractRequest;

final class MainRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'page' => [
                'int',
            ],
            'per_page' => [
                'int',
                'min:4',
            ],
            'order_column' => [
                'string',
                Rule::in(['created_at']),
            ],
            'order_by' => [
                'string',
                Rule::in(['asc', 'desc']),
            ],
            'filters.period_from' => 'date|date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): PaginationFilterDto
    {
        $requestFilters = $this->get('filters');
        $filters = [];

        if (isset($requestFilters['period_from'])) {
            $filters['period_from'] = $requestFilters['period_from'];
        }

        return PaginationFilterDto::fromArray([
            'page' => $this->get('page') ? (int)$this->get('page') : null,
            'per_page' => $this->get('per_page') ? (int)$this->get('per_page') : null,
            'filters' => $filters,
            'order_column' => $this->get('order_column'),
            'order_by' => $this->get('order_by'),
        ]);
    }
}
