<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Apollopayment\ClientsDto;
use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\ProfileDto;
use App\Dto\Models\Users\WalletConnectDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\InitWalletConnectPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\Validator;

final class InitWalletConnectRequest extends AbstractRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'wallet_connect_data' => ['required', 'string'],
            'first_name' => ['required', 'string', 'regex:/^[a-zA-Z]+$/i'],
            'last_name' => ['required', 'string', 'regex:/^[a-zA-Z]+$/i'],
            'email' => ['required', 'email'],
            'ref_code' => ['nullable', 'string'],
            'phone_number' => ['required', 'string'],
            'phone_number_code' => ['required', 'string'],
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            checkWalletConnectAuthorizationValidator($validator, $this->request->get('wallet_connect_data'));
        });
    }

    public function messages(): array
    {
        return [];
    }

    /**
     * @return InitWalletConnectPipelineDto
     */
    public function dto(): InitWalletConnectPipelineDto
    {
        $walletConnectData = json_decode($this->get('wallet_connect_data'), true);

        return InitWalletConnectPipelineDto::fromArray([
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
            'wallet_connect' => WalletConnectDto::fromArray([
                'address' => $walletConnectData['address'],
            ]),
            'apolloClient' => ClientsDto::fromArray([]),
        ]);
    }
}
