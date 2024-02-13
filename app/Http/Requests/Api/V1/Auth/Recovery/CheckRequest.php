<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Recovery;

use App\Dto\Models\Auth\CodeDto;
use App\Http\Requests\AbstractRequest;

final class CheckRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [
            'code' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): CodeDto
    {
        return CodeDto::fromArray([
            'code' => strval($this->get('code')),
        ]);
    }
}
