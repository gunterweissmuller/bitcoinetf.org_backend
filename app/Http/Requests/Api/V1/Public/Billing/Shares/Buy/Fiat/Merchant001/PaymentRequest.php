<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001;

use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\PaymentPipelineDto;
use App\Http\Requests\AbstractRequest;

class PaymentRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'replenishment_uuid' => ['required', 'uuid'],
            'method' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): PaymentPipelineDto
    {
        return PaymentPipelineDto::fromArray([
            'replenishment' => ReplenishmentDto::fromArray([
                'uuid' => $this->get('replenishment_uuid'),
            ]),
            'method' => $this->get('method'),
        ]);
    }
}
