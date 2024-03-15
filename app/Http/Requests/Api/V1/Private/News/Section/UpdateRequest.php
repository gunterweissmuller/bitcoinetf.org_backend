<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\News\Section;

use App\Dto\Models\News\SectionDto;
use App\Http\Requests\AbstractRequest;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:250'],
            'description' => ['nullable', 'string'],
            'slug' => [
                'required',
                'string',
                'min:1',
                'unique:App\Models\News\Section,slug,'.request()->route()->parameters['uuid']
            ],
            'meta_title' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): SectionDto
    {
        return SectionDto::fromArray($this->only([
            'title',
            'description',
            'slug',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ]));
    }
}
