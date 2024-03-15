<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Billing\Withdrawal;

use App\Dto\Models\Billing\WalletDto;
use App\Enums\Billing\Wallet\TypeEnum as WalletTypeEnum;
use App\Enums\Billing\Wallet\WithdrawalMethodEnum;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

final class MethodRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'wallet_type' => [
                'required',
                'string',
                Rule::in(WalletTypeEnum::DIVIDENDS->value, WalletTypeEnum::REFERRAL->value),
            ],
            'method' => ['required', 'string', new Enum(WithdrawalMethodEnum::class)],
            'address' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ?WalletDto
    {
        return WalletDto::fromArray([
            'account_uuid' => $this->payload()->getUuid(),
            'type' => $this->get('wallet_type'),
            'withdrawal_address' => $this->get('address'),
            'withdrawal_method' => $this->get('method'),
        ]);
    }
}
