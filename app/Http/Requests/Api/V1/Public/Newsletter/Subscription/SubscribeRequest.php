<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Newsletter\Subscription;

use App\Dto\Models\Users\EmailDto;
use App\Http\Requests\AbstractRequest;

final class SubscribeRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:dns'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ?EmailDto
    {
        return EmailDto::fromArray([
            'email' => $this->get('email'),
        ]);
    }
}
