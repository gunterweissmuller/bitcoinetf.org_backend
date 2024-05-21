<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V3\Public\Billing\Shares\Sell;

use App\Dto\DtoInterface;
use App\Http\Requests\AbstractRequest;

final class InitSellRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * @return DtoInterface|null
     */
    public function dto(): ?DtoInterface
    {
        return null;
    }
}
