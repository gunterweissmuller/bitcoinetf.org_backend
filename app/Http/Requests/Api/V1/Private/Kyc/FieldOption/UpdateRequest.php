<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Kyc\FieldOption;

use App\Dto\Models\Kyc\FieldOptionDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'field_uuid' => ['required', 'uuid', 'exists:App\Models\Kyc\Field,uuid'],
            'label' => ['nullable', 'string', 'min:2', 'max:250'],
            'value' => [
                'required',
                'string',
                'min:2',
                'max:250',
                Rule::unique('pgsql.kyc.field_options', 'value')
                    ->ignore(request()->route()->parameters['uuid'], 'uuid')
                    ->where(function ($query) {
                        $query->where([
                            'field_uuid' => $this->get('field_uuid') ?? null,
                            'value' => $this->get('value') ?? null,
                        ]);
                    })
            ],
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
            'label',
            'value',
        ]));
    }
}
