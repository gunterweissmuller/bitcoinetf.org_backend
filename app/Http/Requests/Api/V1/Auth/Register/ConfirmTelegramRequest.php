<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\TelegramDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmTelegramPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\Validator;

final class ConfirmTelegramRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'code' => ['required', 'string'],
            'telegram_data' => ['required', 'string'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            checkTelegramAuthorizationValidator($validator, $this->request->get('telegram_data'));
        });
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ConfirmTelegramPipelineDto
    {
        $telegramData = json_decode($this->get('telegram_data'), true);

        return ConfirmTelegramPipelineDto::fromArray([
            'email' => EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            'code' => CodeDto::fromArray([
                'code' => strval($this->get('code')),
            ]),
            'account' => AccountDto::fromArray([]),
            'telegram' => TelegramDto::fromArray([
                'telegram_id' => $telegramData['id'],
            ]),
        ]);
    }
}
