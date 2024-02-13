<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Pages\Page;

use App\Http\Requests\AbstractRequest;
use App\Dto\Models\Pages\PagePaginationFilterDto;

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
            'slug' => 'string|min:2|max:250',
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): PagePaginationFilterDto
    {
        return PagePaginationFilterDto::fromArray([
            'page' => $this->get('page') ? (int)$this->get('page') : null,
            'per_page' => $this->get('per_page') ? (int)$this->get('per_page') : null,
            'slug' => $this->get('slug'),
        ]);
    }
}
