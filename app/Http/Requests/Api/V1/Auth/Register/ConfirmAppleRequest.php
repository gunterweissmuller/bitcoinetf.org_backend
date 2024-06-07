<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\AppleAccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmApplePipelineDto;
use App\Http\Requests\AbstractRequest;
use App\Services\Utils\AppleAuthJWTService;
use Laravel\Socialite\Facades\Socialite;

final class ConfirmAppleRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'apple_token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'code' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ConfirmApplePipelineDto
    {
        config()->set('services.apple.client_secret', AppleAuthJWTService::getInstance()->getSecretKey());
        $socialiteUser = Socialite::driver('apple')->stateless()->userByIdentityToken($this->get('apple_token'));

        return ConfirmApplePipelineDto::fromArray([
            'email' => EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            'code' => CodeDto::fromArray([
                'code' => strval($this->get('code')),
            ]),
            'account' => AccountDto::fromArray([]),
            'apple_account' => AppleAccountDto::fromArray([
                'apple_id' => strtolower($socialiteUser->getId()),
            ]),
            'metadata' => MetadataDto::fromArray([
                'ipv4_address' => request()->header('cf-connecting-ip'),
                'user_agent' => request()->userAgent(),
            ]),
        ]);
    }
}
