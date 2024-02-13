<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Kyc\Field;

use App\Dto\Models\Kyc\FieldDto;
use App\Http\Requests\AbstractRequest;

final class ListRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'screen_uuid' => ['required', 'uuid', 'exists:App\Models\Kyc\Screen,uuid'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): FieldDto
    {
        return FieldDto::fromArray($this->only([
            'screen_uuid',
        ]));
    }
}
