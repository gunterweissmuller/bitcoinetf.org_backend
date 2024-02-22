<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Login;

use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\WalletDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginMetamaskPipelineDto;
use App\Http\Requests\AbstractRequest;

final class LoginMetamaskRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [
            'wallet_address' => ['required', 'string'],
            'message' => ['required', 'string'],
            'signature' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): LoginMetamaskPipelineDto
    {
        return new LoginMetamaskPipelineDto(
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
