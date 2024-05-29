<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\AuthType;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\WalletConnectDto;
use App\Dto\Pipelines\Api\V1\Auth\AuthType\AuthTypeWalletConnectPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\Validator;

final class AuthTypeWalletConnectRequest extends AbstractRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return ['wallet_connect_data' => ['required', 'string']];
    }

    /**
     * @param Validator $validator
     * @return Validator
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            checkWalletConnectAuthorizationValidator($validator, $this->request->get('wallet_connect_data'));
        });

        return $validator;
    }

    public function messages(): array
    {
        return [];
    }

    /**
     * @return AuthTypeWalletConnectPipelineDto
     */
    public function dto(): AuthTypeWalletConnectPipelineDto
    {
        $walletConnectData = json_decode($this->get('wallet_connect_data'), true);

        return AuthTypeWalletConnectPipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'wallet_connect' => WalletConnectDto::fromArray([
                'address' => $walletConnectData['address'],
            ]),
            'auth_type' => null,
        ]);
    }
}
