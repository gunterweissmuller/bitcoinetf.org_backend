<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Code;

use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Pipelines\Api\V1\Auth\Code\CheckPipelineDto;
use App\Http\Requests\AbstractRequest;

final class CheckRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'code' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): CheckPipelineDto
    {
        return new CheckPipelineDto(
            EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            CodeDto::fromArray([
                'code' => strval($this->get('code')),
            ]),
        );
    }
}
