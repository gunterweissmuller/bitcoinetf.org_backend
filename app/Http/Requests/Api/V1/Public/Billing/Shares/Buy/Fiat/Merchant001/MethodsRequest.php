<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001;

use App\Dto\Models\Billing\ReplenishmentDto;
use App\Http\Requests\AbstractRequest;

class MethodsRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'replenishment_uuid' => ['required', 'uuid'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ReplenishmentDto
    {
        return ReplenishmentDto::fromArray([
            'uuid' => $this->get('replenishment_uuid'),
        ]);
    }
}
