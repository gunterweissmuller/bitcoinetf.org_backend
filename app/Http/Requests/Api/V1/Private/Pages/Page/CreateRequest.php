<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Pages\Page;

use App\Dto\Models\Pages\PageDto;
use App\Enums\Pages\Pages\StatusEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;

final class CreateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:250',
            'slug' => 'required|string|min:1|max:250',
            'status' => [
                'required',
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
