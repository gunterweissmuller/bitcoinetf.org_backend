<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Dto\DtoInterface;
use App\Http\Requests\AbstractRequest;

final class EmptyRequest extends AbstractRequest
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
