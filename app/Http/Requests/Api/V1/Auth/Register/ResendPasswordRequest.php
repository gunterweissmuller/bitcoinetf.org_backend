<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Users\EmailDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ResendPasswordPipelineDto;
use App\Http\Requests\AbstractRequest;

final class ResendPasswordRequest extends AbstractRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * @return ResendPasswordPipelineDto
     */
    public function dto(): ResendPasswordPipelineDto
    {
        return ResendPasswordPipelineDto::fromArray([
            'email' => EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
        ]);
    }
}
