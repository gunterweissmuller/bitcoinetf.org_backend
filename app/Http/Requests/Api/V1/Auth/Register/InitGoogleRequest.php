<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\ProfileDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitGooglePipelineDto;
use App\Http\Requests\AbstractRequest;
use Laravel\Socialite\Facades\Socialite;

final class InitGoogleRequest extends AbstractRequest
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

    public function dto(): InitGooglePipelineDto
    {
        $socialiteUser = Socialite::driver('google')->stateless()->user();
        $familyName = $socialiteUser->offsetExists('family_name') ? ucfirst(strtolower($socialiteUser->offsetGet('family_name'))) : '';

        return InitGooglePipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'profile' => ProfileDto::fromArray([
                'full_name' => ucfirst(strtolower($socialiteUser->offsetGet('given_name'))) . ' ' . $familyName,
            ]),
            'email' => EmailDto::fromArray([
                'email' => strtolower($socialiteUser->getEmail()),
            ]),
            'ref_code' => CodeDto::fromArray([
                'code' => $this->get('ref_code') ? strtoupper($this->get('ref_code')) : null,
            ]),
        ]);
    }
}
