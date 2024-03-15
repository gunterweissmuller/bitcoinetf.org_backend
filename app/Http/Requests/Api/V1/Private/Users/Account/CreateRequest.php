<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Private\Users\Account;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Pipelines\Api\V1\Private\Users\Account\CreatePipelineDto;
use App\Enums\Users\Account\PaymentTypeEnum as AccountPaymentTypeEnum;
use App\Enums\Users\Account\StatusEnum as AccountStatusEnum;
use App\Enums\Users\Account\TypeEnum as AccountTypeEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rules\Enum;

final class CreateRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:App\Models\Users\Email,email'],
            'username' => ['required', 'string', 'unique:App\Models\Users\Account,username'],
            'type' => ['required', 'string', new Enum(AccountTypeEnum::class)],
            'password' => ['required', 'string'],
            'status' => ['nullable', 'string', new Enum(AccountStatusEnum::class)],
            'payment_type' => ['nullable', 'string', new Enum(AccountPaymentTypeEnum::class)],
            'personal_bonus' => ['nullable', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): CreatePipelineDto
    {
        return CreatePipelineDto::fromArray([
            'email' => EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            'account' => AccountDto::fromArray([
                ...$this->only([
                    'username',
                    'type',
                    'password',
                    'status',
                    'payment_type',
                ]),
                'personal_bonus' => $this->get('personal_bonus') ? (float) $this->get('personal_bonus') : null
            ]),
        ]);
    }
}
