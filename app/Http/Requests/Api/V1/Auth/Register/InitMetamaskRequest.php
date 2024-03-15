<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\ProfileDto;
use App\Dto\Models\Users\WalletDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitMetamaskPipelineDto;
use App\Http\Requests\AbstractRequest;

final class InitMetamaskRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'regex:/^[a-zA-Z]+$/i'],
            'last_name' => ['required', 'string', 'regex:/^[a-zA-Z]+$/i'],
            'email' => ['required', 'email'],
            'wallet_address' => ['required', 'string'],
            'message' => ['required', 'string'],
            'signature' => ['required', 'string'],
            'ref_code' => ['nullable', 'string'],
            'phone_number' => ['required', 'string'],
            'phone_number_code' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): InitMetamaskPipelineDto
    {
        return InitMetamaskPipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'profile' => ProfileDto::fromArray([
                'full_name' => ucfirst(strtolower($this->get('first_name'))) . ' ' . ucfirst(strtolower($this->get('last_name'))),
                'phone_number' => preg_replace('/\s+/', '', $this->get('phone_number')),
                'phone_number_code' => $this->get('phone_number_code'),
            ]),
            'email' => EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            'ref_code' => CodeDto::fromArray([
                'code' => $this->get('ref_code') ? strtoupper($this->get('ref_code')) : null,
            ]),
            'wallet' => WalletDto::fromArray([
                'wallet' => strtolower($this->get('wallet_address')),
            ]),
        ]);
    }
}
