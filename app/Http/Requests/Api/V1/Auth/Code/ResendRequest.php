<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Code;

use App\Dto\Models\Users\EmailDto;
use App\Dto\Pipelines\Api\V1\Auth\Code\ResendPipelineDto;
use App\Http\Requests\AbstractRequest;

final class ResendRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ResendPipelineDto
    {
        return new ResendPipelineDto(
            EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            null,
        );
    }
}
