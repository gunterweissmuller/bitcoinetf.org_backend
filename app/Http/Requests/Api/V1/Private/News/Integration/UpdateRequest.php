<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\News\Integration;

use App\Enums\News\Integration\StatusEnum;
use App\Http\Requests\AbstractRequest;
use App\Dto\Models\News\IntegrationDto;
use Illuminate\Validation\Rule;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|min:2|max:250',
            'public_key' => 'string|min:2|max:250',
            'private_key' => 'string|min:2|max:250',
            'link' => 'string|min:2|max:250',
            'status' => [
                'string',
                Rule::in(StatusEnum::values())
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): IntegrationDto
    {
        return IntegrationDto::fromArray($this->only([
            'name',
            'public_key',
            'private_key',
            'link',
            'status',
        ]));
    }
}
