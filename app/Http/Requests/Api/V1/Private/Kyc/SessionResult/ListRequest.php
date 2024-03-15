<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Kyc\SessionResult;

use App\Dto\Models\Kyc\SessionResultDto;
use App\Http\Requests\AbstractRequest;

final class ListRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'session_uuid' => ['nullable', 'uuid', 'exists:App\Models\Kyc\Session,uuid'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): SessionResultDto
    {
        return SessionResultDto::fromArray($this->only([
            'session_uuid',
        ]));
    }
}
