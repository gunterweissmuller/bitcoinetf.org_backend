<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Pages\Language;

use App\Http\Requests\AbstractRequest;
use App\Dto\Models\Pages\LanguageDto;

final class CreateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:250',
            'slug' => 'required|string|min:2|max:250',
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
