<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Pages\Language;

use App\Dto\Models\Pages\LanguageDto;
use App\Http\Requests\AbstractRequest;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|min:2|max:250',
            'slug' => 'string|min:2|max:250',
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): LanguageDto
    {
        return LanguageDto::fromArray($this->only([
            'name',
            'slug',
        ]));
    }
}
