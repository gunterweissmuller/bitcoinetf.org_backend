<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\News\Article;

use App\Dto\Models\News\ArticleDto;
use App\Dto\Pipelines\Api\V1\Private\News\Article\ArticlePipelineDto;
use App\Http\Requests\AbstractRequest;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'section_uuid' => ['required', 'uuid', 'exists:App\Models\News\Section,uuid'],
            'title' => ['required', 'string', 'min:2', 'max:250'],
            'description' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'slug' => [
                'required',
                'string',
                'min:1',
                'unique:App\Models\News\Article,slug,'.request()->route()->parameters['uuid'],
            ],
            'reading_time' => ['nullable', 'integer'],
            'meta_title' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'tag_uuids' => ['nullable', 'array'],
            'tag_uuids.*' => ['nullable', 'uuid', 'exists:App\Models\News\Tag,uuid'],
            'preview_file_uuid' => ['nullable', 'uuid'],
            'main_file_uuid' => ['nullable', 'uuid'],
            'created_at' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ArticlePipelineDto
    {
        return ArticlePipelineDto::fromArray([
            'article' => ArticleDto::fromArray([
                ...$this->only([
                    'section_uuid',
                    'title',
                    'description',
                    'content',
                    'slug',
                    'meta_title',
                    'meta_description',
                    'meta_keywords',
                    'created_at',
                ]),
                'reading_time' => (integer) $this->get('reading_time'),
            ]),
            'tag_uuids' => $this->get('tag_uuids') ?? [],
            'preview_file_uuid' => $this->get('preview_file_uuid') ?? null,
            'main_file_uuid' => $this->get('main_file_uuid') ?? null,
        ]);
    }
}
