<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Billing\Withdrawal;

use App\Dto\Models\Billing\WithdrawalDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\ReferralCallbackPipelineDto;
use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;

final class ReferralCallbackRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required', 'uuid', 'exists:App\Models\Billing\Withdrawal,uuid'],
            'status' => [
                'required',
                'string',
                Rule::in([
                    'Success',
                    'success',
                    'Failed',
                    'failed',
                    'Expired',
                    'expired'
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ReferralCallbackPipelineDto
    {
        return ReferralCallbackPipelineDto::fromArray([
            'account' => AccountDto::fromArray($this->payload()->toArray()),
            'withdrawal' => WithdrawalDto::fromArray([
                'uuid' => $this->get('uuid'),
            ]),
            'status' => strtolower($this->get('status')),
        ]);
    }
}
