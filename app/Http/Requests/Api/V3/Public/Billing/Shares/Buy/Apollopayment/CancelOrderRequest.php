<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Apollopayment\CancelOrderPipelineDto;
use App\Enums\Billing\Replenishment\StatusEnum;
use App\Http\Requests\AbstractRequest;

final class CancelOrderRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ?CancelOrderPipelineDto
    {
        return CancelOrderPipelineDto::fromArray([
            'replenishment' => ReplenishmentDto::fromArray([
                'status' => StatusEnum::INIT->value,
                'account_uuid' => $this->payload()->getUuid(),
                'uuid' => $this->get('replenishment_uuid'),
            ])
        ]);
    }
}
