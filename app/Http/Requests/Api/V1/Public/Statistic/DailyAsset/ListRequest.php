<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Statistic\DailyAsset;

use Illuminate\Validation\Rule;
use App\Dto\Core\PaginationFilterDto;
use App\Http\Requests\AbstractRequest;

final class ListRequest extends AbstractRequest
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
            'filters.period_to' => 'date|date_format:Y-m-d',
            'filters.asset_uuid' => 'string',
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

        if (isset($requestFilters['period_to'])) {
            $filters['period_to'] = $requestFilters['period_to'];
        }

        if (isset($requestFilters['asset_uuid'])) {
            $filters['asset_uuid'] = $requestFilters['asset_uuid'];
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
