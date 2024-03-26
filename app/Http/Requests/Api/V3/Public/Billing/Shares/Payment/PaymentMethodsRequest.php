<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V3\Public\Billing\Shares\Payment;

use App\Dto\DtoInterface;
use App\Http\Requests\AbstractRequest;

final class PaymentMethodsRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ?DtoInterface
    {
        return null;
    }
}

