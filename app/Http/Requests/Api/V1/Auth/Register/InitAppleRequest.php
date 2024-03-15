<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\AppleAccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\ProfileDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitApplePipelineDto;
use App\Http\Requests\AbstractRequest;
use Laravel\Socialite\Facades\Socialite;

final class InitAppleRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'ref_code' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): InitApplePipelineDto
    {
        //@fixme-v
//        $socialiteUser = Socialite::driver('sign-in-with-apple')->stateless()->user();
//        $firstName = $socialiteUser->offsetExists('firstName') ? ucfirst(strtolower($socialiteUser->offsetGet('firstName'))) : '';
//        $lastName = $socialiteUser->offsetExists('lastName') ? ucfirst(strtolower($socialiteUser->offsetGet('lastName'))) : '';

        return InitApplePipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'profile' => ProfileDto::fromArray([
//                'full_name' => $firstName . ' ' . $lastName,
                'full_name' => '',
            ]),
            'email' => EmailDto::fromArray([
//                'email' => strtolower($socialiteUser->getEmail() ?? ''),
                'email' => 'email',
            ]),
            'apple_account' => AppleAccountDto::fromArray([
//                'apple_id' => strtolower($socialiteUser->getId()),
                'apple_id' => 'apple-------id',
            ]),
            'ref_code' => CodeDto::fromArray([
                'code' => $this->get('ref_code') ? strtoupper($this->get('ref_code')) : null,
            ]),
        ]);
    }
}
