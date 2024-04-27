<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Login;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\AppleAccountDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginApplePipelineDto;
use App\Http\Requests\AbstractRequest;
use App\Services\Utils\AppleAuthJWTService;
use Laravel\Socialite\Facades\Socialite;

final class LoginAppleRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [
            'apple_token' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): LoginApplePipelineDto
    {
        config()->set('services.apple.client_secret', AppleAuthJWTService::getInstance()->getSecretKey());
        $socialiteUser = Socialite::driver('apple')->stateless()->userByIdentityToken($this->get('apple_token'));

        return LoginApplePipelineDto::fromArray([
                'account' => AccountDto::fromArray([]),
                'apple_account' => AppleAccountDto::fromArray([
                    'apple_id' => strtolower($socialiteUser->getId()),
                ]),
                'metadata' => MetadataDto::fromArray([
                    'ipv4_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]),
            ]
        );
    }
}
