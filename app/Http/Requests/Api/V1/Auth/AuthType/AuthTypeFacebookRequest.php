<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\AuthType;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\FacebookDto;
use App\Dto\Pipelines\Api\V1\Auth\AuthType\AuthTypeFacebookPipelineDto;
use App\Http\Requests\AbstractRequest;

final class AuthTypeFacebookRequest extends AbstractRequest
{

    public function rules(): array
    {
        return ['facebook_id' => ['required', 'integer']];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): AuthTypeFacebookPipelineDto
    {
        return AuthTypeFacebookPipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'facebook' => FacebookDto::fromArray([
                'facebook_id' => (int)$this->get('facebook_id'),
            ]),
            'auth_type' => null,
        ]);
    }
}
