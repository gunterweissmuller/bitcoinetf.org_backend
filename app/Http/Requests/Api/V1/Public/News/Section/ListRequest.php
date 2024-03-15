<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\News\Section;

use App\Dto\Core\PaginationFilterDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;

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
            'order_column' => [
                'string',
                Rule::in([
                    'number',
                    'username',
                    'type',
                    'status',
                    'payment_type',
                    'personal_bonus',
                    'created_at',
                    'updated_at',
                ]),
            ],
            'order_by' => [
                'string',
                Rule::in(['asc', 'desc']),
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): PaginationFilterDto
    {
        return PaginationFilterDto::fromArray([
            'page' => $this->get('page') ? (int) $this->get('page') : null,
            'per_page' => $this->get('per_page') ? (int) $this->get('per_page') : null,
            'filters' => [],
            'order_column' => $this->get('order_column'),
            'order_by' => $this->get('order_by'),
        ]);
    }
}
