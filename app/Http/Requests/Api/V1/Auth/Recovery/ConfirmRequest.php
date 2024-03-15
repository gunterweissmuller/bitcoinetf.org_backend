<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Recovery;

use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V1\Auth\Recovery\ConfirmPipelineDto;
use App\Http\Requests\AbstractRequest;

final class ConfirmRequest extends AbstractRequest
{

    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ConfirmPipelineDto
    {
        return new ConfirmPipelineDto(
            CodeDto::fromArray([
                'code' => strval($this->get('code')),
            ]),
            AccountDto::fromArray([
                'password' => $this->get('password'),
            ]),
        );
    }
}
