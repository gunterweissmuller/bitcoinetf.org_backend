<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\AuthType;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\TelegramDto;
use App\Dto\Pipelines\Api\V1\Auth\AuthType\AuthTypeTelegramPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\Validator;

final class AuthTypeTelegramRequest extends AbstractRequest
{

    public function rules(): array
    {
        return ['telegram_data' => ['required', 'string']];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            checkTelegramAuthorizationValidator($validator, $this->request->get('telegram_data'));
        });

        return $validator;
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): AuthTypeTelegramPipelineDto
    {
        $telegramData = json_decode($this->get('telegram_data'), true);
        return AuthTypeTelegramPipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'telegram' => TelegramDto::fromArray([
                'telegram_id' => $telegramData['id'],
            ]),
            'auth_type' => null,
        ]);
    }
}
