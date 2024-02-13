<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Kyc\Session;

use App\Dto\Models\Kyc\SessionDto;
use App\Http\Requests\AbstractRequest;

final class ListRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'form_uuid' => ['nullable', 'uuid', 'exists:App\Models\Kyc\Form,uuid'],
            'account_uuid' => ['nullable', 'uuid', 'exists:App\Models\Users\Account,uuid'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): SessionDto
    {
        return SessionDto::fromArray($this->only([
            'form_uuid',
            'account_uuid',
        ]));
    }
}
