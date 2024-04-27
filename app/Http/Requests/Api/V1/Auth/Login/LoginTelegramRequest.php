<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Login;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Models\Users\TelegramDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginTelegramPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\Validator;

final class LoginTelegramRequest extends AbstractRequest
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
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): LoginTelegramPipelineDto
    {
        $telegramData = json_decode($this->get('telegram_data'), true);
        return LoginTelegramPipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'telegram' => TelegramDto::fromArray([
                'telegram_id' => $telegramData['id'],
            ]),
            'metadata' => MetadataDto::fromArray([
                'ipv4_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]),
        ]);
    }
}
