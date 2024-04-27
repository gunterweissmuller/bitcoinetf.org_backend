<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Login;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\FacebookDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginFacebookPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\Validator;

final class LoginFacebookRequest extends AbstractRequest
{

    public function rules(): array
    {
        return ['facebook_id' => ['required', 'integer']];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): LoginFacebookPipelineDto
    {
        return LoginFacebookPipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'facebook' => FacebookDto::fromArray([
                'facebook_id' => (int)$this->get('facebook_id'),
            ]),
            'metadata' => MetadataDto::fromArray([
                'ipv4_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]),
        ]);
    }
}
