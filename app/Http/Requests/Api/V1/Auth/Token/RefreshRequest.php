<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Token;

use App\Dto\Core\JwtDto;
use App\Dto\Pipelines\Api\V1\Auth\Token\RefreshPipelineDto;
use App\Http\Requests\AbstractRequest;

final class RefreshRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [
            'refresh_token' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): RefreshPipelineDto
    {
        return new RefreshPipelineDto(
            null,
            null,
            null,
            JwtDto::fromArray([
                'token' => $this->get('refresh_token'),
            ]),
        );
    }
}
