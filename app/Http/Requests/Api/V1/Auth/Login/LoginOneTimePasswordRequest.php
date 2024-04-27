<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Login;

use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginOneTimePasswordPipelineDto;
use App\Http\Requests\AbstractRequest;

final class LoginOneTimePasswordRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): LoginOneTimePasswordPipelineDto
    {
        return LoginOneTimePasswordPipelineDto::fromArray([
                'email' => EmailDto::fromArray([
                    'email' => strtolower($this->get('email')),
                ]),
                'code' => CodeDto::fromArray([
                    'code' => strval($this->get('password')),
                ]),
            ]
        );
    }
}
