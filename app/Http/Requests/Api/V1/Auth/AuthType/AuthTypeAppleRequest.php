<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\AuthType;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\AppleAccountDto;
use App\Dto\Pipelines\Api\V1\Auth\AuthType\AuthTypeApplePipelineDto;
use App\Http\Requests\AbstractRequest;
use App\Services\Utils\AppleAuthJWTService;
use Laravel\Socialite\Facades\Socialite;

final class AuthTypeAppleRequest extends AbstractRequest
{

    public function rules(): array
    {
        return ['apple_token' => ['required', 'string']];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): AuthTypeApplePipelineDto
    {
        config()->set('services.apple.client_secret', AppleAuthJWTService::getInstance()->getSecretKey());
        $socialiteUser = Socialite::driver('apple')->stateless()->userByIdentityToken($this->get('apple_token'));

        return AuthTypeApplePipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'apple_account' => AppleAccountDto::fromArray([
                'apple_id' => strtolower($socialiteUser->getId()),
            ]),
            'auth_type' => null,
        ]);
    }
}
