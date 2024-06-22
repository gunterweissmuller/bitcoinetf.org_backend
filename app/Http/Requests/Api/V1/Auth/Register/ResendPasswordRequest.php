<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Users\EmailDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ResendPasswordPipelineDto;
use App\Http\Requests\AbstractRequest;

final class ResendPasswordRequest extends AbstractRequest
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

    public function dto(): ResendPasswordPipelineDto
    {
        return new ResendPasswordPipelineDto(
            EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            null,
        );
    }
}
