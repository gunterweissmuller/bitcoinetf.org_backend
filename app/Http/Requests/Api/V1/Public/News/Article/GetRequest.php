<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\News\Article;

use App\Dto\Requests\V1\Public\News\Article\GetRequestDto;
use App\Http\Requests\AbstractRequest;

final class GetRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['nullable', 'uuid', 'exists:App\Models\News\Article,uuid'],
            'section_slug' => ['nullable', 'string'],
            'article_slug' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): GetRequestDto
    {
        return GetRequestDto::fromArray($this->only([
            'uuid',
            'section_slug',
            'article_slug',
        ]));
    }
}
