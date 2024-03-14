<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\News\Tag;

use App\Dto\Models\News\TagDto;
use App\Http\Requests\AbstractRequest;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'section_uuid' => ['required', 'uuid', 'exists:App\Models\News\Section,uuid'],
            'title' => [
                'required',
                'string',
                'min:2',
                'max:250',
                'unique:App\Models\News\Tag,title,'.request()->route()->parameters['uuid']
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): TagDto
    {
        return TagDto::fromArray($this->only([
            'section_uuid',
            'title',
        ]));
    }
}
