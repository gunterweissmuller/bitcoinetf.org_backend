<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Kyc\Form;

use App\Dto\Models\Kyc\FormDto;
use App\Enums\Kyc\Form\StatusEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:250'],
            'status' => ['required', 'string', Rule::in(StatusEnum::values())],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): FormDto
    {
        return FormDto::fromArray($this->only([
            'title',
            'status',
        ]));
    }
}
