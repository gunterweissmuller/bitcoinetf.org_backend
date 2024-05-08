<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\FacebookDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmFacebookPipelineDto;
use App\Http\Requests\AbstractRequest;

final class ConfirmFacebookRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'code' => ['required', 'string'],
            'facebook_id' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ConfirmFacebookPipelineDto
    {
        return ConfirmFacebookPipelineDto::fromArray([
            'email' => EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
            'code' => CodeDto::fromArray([
                'code' => strval($this->get('code')),
            ]),
            'account' => AccountDto::fromArray([]),
            'facebook' => FacebookDto::fromArray([
                'facebook_id' => (int)$this->get('facebook_id'),
            ]),
            'metadata' => MetadataDto::fromArray([
                'ipv4_address' => request()->header('cf-connecting-ip'),
                'user_agent' => request()->userAgent(),
            ]),
        ]);
    }
}
