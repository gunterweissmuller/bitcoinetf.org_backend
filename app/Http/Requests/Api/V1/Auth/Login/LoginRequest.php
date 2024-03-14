<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Login;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginPipelineDto;
use App\Http\Requests\AbstractRequest;

final class LoginRequest extends AbstractRequest
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

    public function dto(): LoginPipelineDto
    {
        return new LoginPipelineDto(
            EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            AccountDto::fromArray([
                'password' => $this->get('password'),
            ]),
            null,
            null,
        );
    }
}
