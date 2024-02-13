<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Billing\Withdrawal;

use App\Dto\Core\PaginationFilterDto;
use App\Enums\Billing\Withdrawal\StatusEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'status' => [
                'nullable',
                'string',
                new Enum(StatusEnum::class)
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): PaginationFilterDto
    {
        $filters = [
            'account_uuid' => $this->payload()->getUuid(),
        ];

        if ($this->get('status')) {
            $filters['status'] = $this->get('status');
        }

        return PaginationFilterDto::fromArray([
            'page' => $this->get('page') ? (int) $this->get('page') : null,
            'per_page' => $this->get('per_page') ? (int) $this->get('per_page') : null,
            'filters' => $filters,
            'order_column' => $this->get('order_column'),
            'order_by' => $this->get('order_by'),
        ]);
    }
}
