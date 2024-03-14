<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Kyc\Screen;

use App\Dto\Models\Kyc\ScreenDto;
use App\Http\Requests\AbstractRequest;

final class ListRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'form_uuid' => ['required', 'uuid', 'exists:App\Models\Kyc\Form,uuid'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ScreenDto
    {
        return ScreenDto::fromArray($this->only([
            'form_uuid',
        ]));
    }
}
