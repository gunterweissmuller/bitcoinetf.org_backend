<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Auth\CodeDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmPipelineDto;
use App\Http\Requests\AbstractRequest;

final class ConfirmRequest extends AbstractRequest
{
    const FAST_KEY = 'fast';

    public function rules(): array
    {
        if ($this->has(self::FAST_KEY)) {
            return [
                'email' => ['required', 'email'],
//                'code' => ['required', 'string'],
            ];
        } else {
            return [
                'email' => ['required', 'email'],
//                'code' => ['required', 'string'],
                'password' => ['required', 'string'],
            ];
        }
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ConfirmPipelineDto
    {
        return ConfirmPipelineDto::fromArray([
            'email' => EmailDto::fromArray([
                'email' => strtolower($this->get('email')),
            ]),
//            'code' => CodeDto::fromArray([
//                'code' => strval($this->get('code')),
//            ]),
            'account' => AccountDto::fromArray([
                'password' => $this->get('password'),
            ]),
            'is_fast' => $this->has(self::FAST_KEY),
            'metadata' => MetadataDto::fromArray([
                'ipv4_address' => request()->header('cf-connecting-ip'),
                'user_agent' => request()->userAgent(),
            ]),
        ]);
    }
}
