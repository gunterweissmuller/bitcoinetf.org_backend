<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Apollopayment\ClientsDto;
use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\ProfileDto;
use App\Dto\Models\Users\TelegramDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitTelegramPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\Validator;

final class InitTelegramRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [
            'telegram_data' => ['required', 'string'],
            'first_name' => ['required', 'string', 'regex:/^[a-zA-Z]+$/i'],
            'last_name' => ['required', 'string', 'regex:/^[a-zA-Z]+$/i'],
            'email' => ['required', 'email'],
            'ref_code' => ['nullable', 'string'],
            'phone_number' => ['required', 'string'],
            'phone_number_code' => ['required', 'string'],
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

    public function dto(): InitTelegramPipelineDto
    {
        $telegramData = json_decode($this->get('telegram_data'), true);

        return InitTelegramPipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'profile' => ProfileDto::fromArray([
                'full_name' => ucfirst(strtolower($this->get('first_name'))) . ' ' . ucfirst(strtolower($this->get('last_name'))),
                'phone_number' => preg_replace('/\s+/', '', $this->get('phone_number')),
                'phone_number_code' => $this->get('phone_number_code'),
            ]),
            'email' => EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            'ref_code' => CodeDto::fromArray([
                'code' => $this->get('ref_code') ? strtoupper($this->get('ref_code')) : null,
            ]),
            'telegram' => TelegramDto::fromArray([
                'telegram_id' => $telegramData['id'],
            ]),
            'apolloClient' => ClientsDto::fromArray([]),
        ]);
    }
}
