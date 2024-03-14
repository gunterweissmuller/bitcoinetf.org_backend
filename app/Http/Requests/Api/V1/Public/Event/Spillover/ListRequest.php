<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Event\Spillover;

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
                'max:100',
            ],
            'order_column' => 'string',
            'order_by' => [
                'string',
                Rule::in(['asc', 'desc']),
            ],
            'filters.asset_uuid' => 'string',
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): PaginationFilterDto
    {
        $request = $this->get('filters');
        $filters = [];

        if (isset($request['asset_uuid'])) {
            $filters[] = ['asset_uuid' => $request['asset_uuid']];
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
