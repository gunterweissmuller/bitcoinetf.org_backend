<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Users\Email;

use App\Dto\Models\Users\EmailDto;
use App\Enums\Users\Email\StatusEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rules\Enum;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        $uuid = request()->route('uuid');

        return [
            'email' => ['required', 'string', 'unique:App\Models\Users\Email,email,'.$uuid],
            'status' => ['nullable', 'string', new Enum(StatusEnum::class)],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): EmailDto
    {
        return EmailDto::fromArray($this->only([
            'email',
            'status',
        ]));
    }
}
