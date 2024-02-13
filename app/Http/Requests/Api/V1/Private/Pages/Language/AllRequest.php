<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Pages\Language;

use App\Dto\Core\PaginationFilterDto;
use App\Http\Requests\AbstractRequest;

final class AllRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'page' => [
                'int',
            ],
            'per_page' => [
                'int',
                'min:5',
                'max:100',
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
        ]);
    }
}
