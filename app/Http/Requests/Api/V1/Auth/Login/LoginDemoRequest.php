<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Login;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginPipelineDto;
use App\Http\Requests\AbstractRequest;

final class LoginDemoRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): LoginPipelineDto
    {
        return LoginPipelineDto::fromArray([
            'metadata' => MetadataDto::fromArray([
                'ipv4_address' => request()->header('cf-connecting-ip'),
                'user_agent' => request()->userAgent(),
            ]),
        ]);
    }
}
