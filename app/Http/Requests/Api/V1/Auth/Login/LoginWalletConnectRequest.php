<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Login;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Models\Users\WalletConnectDto;
use App\Dto\Pipelines\Api\V1\Auth\Login\LoginWalletConnectPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Contracts\Validation\Validator;

final class LoginWalletConnectRequest extends AbstractRequest
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
     * @return LoginWalletConnectPipelineDto
     */
    public function dto(): LoginWalletConnectPipelineDto
    {
        $walletConnectData = json_decode($this->get('wallet_connect_data'), true);

        return LoginWalletConnectPipelineDto::fromArray([
            'account' => AccountDto::fromArray([]),
            'wallet_connect' => WalletConnectDto::fromArray([
                'address' => $walletConnectData['address'],
            ]),
            'metadata' => MetadataDto::fromArray([
                'ipv4_address' => request()->header('cf-connecting-ip'),
                'user_agent' => request()->userAgent(),
            ]),
        ]);
    }
}
