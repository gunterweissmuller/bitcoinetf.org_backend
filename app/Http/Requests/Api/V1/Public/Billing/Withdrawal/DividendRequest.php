<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Billing\Withdrawal;

use App\Dto\Models\Billing\WalletDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Enums\Billing\Withdrawal\InitiatorEnum;
use App\Http\Requests\AbstractRequest;

final class DividendRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): DividendPipelineDto
    {
        return DividendPipelineDto::fromArray([
            'wallet' => WalletDto::fromArray([
                'account_uuid' => $this->payload()->getUuid(),
                'type' => TypeEnum::DIVIDENDS->value,
            ]),
        ]);
    }
}
