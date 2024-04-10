<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V3\Public\Billing\Shares\Payment;

use App\Dto\DtoInterface;
use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\Payment\CancelOrderPipelineDto;
use App\Http\Requests\AbstractRequest;

final class CancelOrderRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'replenishment_uuid' => ['required', 'uuid'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * @return CancelOrderPipelineDto|null
     */
    public function dto(): ?CancelOrderPipelineDto
    {
        return CancelOrderPipelineDto::fromArray([
            'replenishment' => ReplenishmentDto::fromArray([
                'account_uuid' => $this->payload()->getUuid(),
                'uuid' => $this->get('replenishment_uuid'),
            ])
        ]);
    }
}

