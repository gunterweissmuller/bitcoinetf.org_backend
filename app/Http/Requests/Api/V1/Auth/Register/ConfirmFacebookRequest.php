<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\FacebookDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmFacebookPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\Validator;

final class ConfirmFacebookRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'code' => ['required', 'string'],
            'facebook_data' => ['required', 'string'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            checkTelegramAuthorizationValidator($validator, $this->request->get('facebook_data'));
        });
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ConfirmFacebookPipelineDto
    {
        $facebookData = json_decode($this->get('facebook_data'), true);

        return ConfirmFacebookPipelineDto::fromArray([
            'email' => EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            'code' => CodeDto::fromArray([
                'code' => strval($this->get('code')),
            ]),
            'account' => AccountDto::fromArray([]),
            'facebook' => FacebookDto::fromArray([
                'facebook_id' => $facebookData['id'],
            ]),
        ]);
    }
}
