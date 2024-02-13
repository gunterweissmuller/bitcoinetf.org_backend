<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Users\Account;

use App\Dto\Models\Users\AccountDto;
use App\Enums\Users\Account\StatusEnum as AccountStatusEnum;
use App\Enums\Users\Account\TypeEnum as AccountTypeEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rules\Enum;

final class UpdateRequest extends AbstractRequest
{
    public function rules(): array
    {
        $uuid = request()->route('uuid');

        return [
            'username' => ['required', 'string', 'unique:App\Models\Users\Account,username,'.$uuid],
            'type' => ['required', 'string', new Enum(AccountTypeEnum::class)],
            'status' => ['nullable', 'string', new Enum(AccountStatusEnum::class)],
            'personal_bonus' => ['nullable', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): AccountDto
    {
        return AccountDto::fromArray([
            ...$this->only([
                'username',
                'type',
                'status',
            ]),
            'personal_bonus' => $this->get('personal_bonus') ? (float) $this->get('personal_bonus') : null
        ]);
    }
}
