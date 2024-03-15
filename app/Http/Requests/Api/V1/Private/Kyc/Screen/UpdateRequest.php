<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Kyc\Screen;

use App\Dto\Models\Kyc\ScreenDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'form_uuid' => ['required', 'uuid', 'exists:App\Models\Kyc\Form,uuid'],
            'title' => ['required', 'string', 'min:2', 'max:250'],
            'subtitle' => ['nullable', 'string', 'min:2', 'max:250'],
            'sort' => [
                'required',
                'integer',
                Rule::unique('pgsql.kyc.screens', 'sort')
                    ->ignore(request()->route()->parameters['uuid'], 'uuid')
                    ->where(function ($query) {
                        $query->where([
                            'form_uuid' => $this->get('form_uuid') ?? null,
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

    public function dto(): ScreenDto
    {
        return ScreenDto::fromArray($this->only([
            'form_uuid',
            'title',
            'subtitle',
            'sort',
        ]));
    }
}
