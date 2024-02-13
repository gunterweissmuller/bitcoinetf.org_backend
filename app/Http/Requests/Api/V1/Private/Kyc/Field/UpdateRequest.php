<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Kyc\Field;

use App\Dto\Models\Kyc\FieldDto;
use App\Enums\Kyc\Field\TypeEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'screen_uuid' => ['required', 'uuid', 'exists:App\Models\Kyc\Screen,uuid'],
            'name' => ['required', 'string', 'min:2', 'max:250', 'unique:App\Models\Kyc\Field,name'],
            'label' => ['nullable', 'string', 'min:2', 'max:250'],
            'type' => ['required', 'string', new Enum(TypeEnum::class)],
            'sort' => [
                'required',
                'integer',
                Rule::unique('pgsql.kyc.fields', 'sort')
                    ->ignore(request()->route()->parameters['uuid'], 'uuid')
                    ->where(function ($query) {
                        $query->where([
                            'screen_uuid' => $this->get('screen_uuid') ?? null,
                            'sort' => $this->get('sort') ?? null,
                        ]);
                    })
            ],
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
            'name',
            'label',
            'type',
            'sort',
        ]));
    }
}
