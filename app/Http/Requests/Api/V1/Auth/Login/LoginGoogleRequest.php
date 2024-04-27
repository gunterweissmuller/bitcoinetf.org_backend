<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Login;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginGooglePipelineDto;
use App\Http\Requests\AbstractRequest;
use Laravel\Socialite\Facades\Socialite;

final class LoginGoogleRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): LoginGooglePipelineDto
    {
        $socialiteUser = Socialite::driver('google')->stateless()->user();

        return LoginGooglePipelineDto::fromArray([
                'account' => AccountDto::fromArray([]),
                'email' => EmailDto::fromArray([
                    'email' => strtolower($socialiteUser->getEmail()),
                ]),
                'metadata' => MetadataDto::fromArray([
                    'ipv4_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]),
            ]
        );
    }
}
