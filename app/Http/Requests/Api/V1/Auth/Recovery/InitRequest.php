<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Recovery;

use App\Dto\Models\Users\EmailDto;
use App\Dto\Pipelines\Api\V1\Auth\Recovery\InitPipelineDto;
use App\Http\Requests\AbstractRequest;

final class InitRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [
            'email' => ['required', 'email']
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): InitPipelineDto
    {
        return new InitPipelineDto(
            EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
        );
    }
}
