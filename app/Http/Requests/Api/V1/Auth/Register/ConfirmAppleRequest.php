<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmApplePipelineDto;
use App\Http\Requests\AbstractRequest;

final class ConfirmAppleRequest extends AbstractRequest
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

    public function dto(): ConfirmApplePipelineDto
    {
        return ConfirmApplePipelineDto::fromArray([
            'email' => EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            'code' => CodeDto::fromArray([
                'code' => strval($this->get('code')),
            ]),
            'account' => AccountDto::fromArray([]),
        ]);
    }
}
