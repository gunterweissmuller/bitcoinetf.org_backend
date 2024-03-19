<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Login;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\FacebookDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginFacebookPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\Validator;

final class LoginFacebookRequest extends AbstractRequest
{

    public function rules(): array
    {
        return ['facebook_data' => ['required', 'string']];
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

    public function dto(): LoginFacebookPipelineDto
    {
        $facebookData = json_decode($this->get('facebook_data'), true);
        return LoginFacebookPipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'facebook' => FacebookDto::fromArray([
                'facebook_id' => $facebookData['id'],
            ]),
        ]);
    }
}
