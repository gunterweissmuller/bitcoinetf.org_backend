<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Kyc\FieldOption;

use App\Dto\Models\Kyc\FieldOptionDto;
use App\Http\Requests\AbstractRequest;

final class ListRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'field_uuid' => ['required', 'uuid', 'exists:App\Models\Kyc\Field,uuid'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): FieldOptionDto
    {
        return FieldOptionDto::fromArray($this->only([
            'field_uuid',
        ]));
    }
}
