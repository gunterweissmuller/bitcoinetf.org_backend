<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Billing\Payment;

use Illuminate\Validation\Rule;
use App\Dto\Core\PaginationFilterDto;
use App\Http\Requests\AbstractRequest;
use App\Enums\Billing\Payment\TypeEnum;

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
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): PaginationFilterDto
    {
        return PaginationFilterDto::fromArray([
            'page' => $this->get('page') ? (int)$this->get('page') : null,
            'per_page' => $this->get('per_page') ? (int)$this->get('per_page') : null,
            'filters' => null,
            'order_column' => $this->get('order_column'),
            'order_by' => $this->get('order_by'),
        ]);
    }
}
