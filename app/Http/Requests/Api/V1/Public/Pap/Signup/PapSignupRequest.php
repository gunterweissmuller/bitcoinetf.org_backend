<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Pap\Signup;

use App\Dto\DtoInterface;
use App\Http\Requests\AbstractRequest;

final class PapSignupRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'pap_id' => ['required', 'string'],
            'utm_label' => ['required', 'string'],
        ];
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
