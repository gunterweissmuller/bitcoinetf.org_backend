<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Kyc\Screen;

use App\Dto\Models\Kyc\FieldOptionDto;
use App\Http\Requests\AbstractRequest;

final class StateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'country' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): FieldOptionDto
    {
        return FieldOptionDto::fromArray([
            'value' => $this->get('country')
        ]);
    }
}
