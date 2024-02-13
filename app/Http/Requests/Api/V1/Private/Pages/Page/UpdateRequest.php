<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Pages\Page;

use App\Dto\Models\Pages\PageDto;
use App\Enums\Pages\Pages\StatusEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|min:2|max:250',
            'slug' => 'string|min:1|max:250',
            'status' => [
                'string',
                Rule::in(array_column(StatusEnum::cases(), 'value')),
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): PageDto
    {
        return PageDto::fromArray($this->only([
            'name',
            'slug',
            'status',
        ]));
    }
}
