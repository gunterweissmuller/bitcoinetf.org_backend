<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth\Register;

use App\Dto\Models\Apollopayment\ClientsDto;
use App\Dto\Models\Users\EmailDto;
use App\Dto\Models\Users\MetadataDto;
use App\Dto\Models\Users\ProfileDto;
use App\Dto\Pipelines\Api\V1\Auth\Register\ConfirmGooglePipelineDto;
use App\Http\Requests\AbstractRequest;

final class ConfirmGoogleRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'phone_number_code' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ConfirmGooglePipelineDto
    {
        return ConfirmGooglePipelineDto::fromArray([
            'profile' => ProfileDto::fromArray([
                'full_name' => ucfirst(strtolower($this->get('first_name'))) . ' ' . ucfirst(strtolower($this->get('last_name'))),
                'phone_number' => preg_replace('/\s+/', '', $this->get('phone_number')),
                'phone_number_code' => $this->get('phone_number_code'),
            ]),
            'email' => EmailDto::fromArray([
                'email' => $this->get('email'),
            ]),
            'apolloClient' => ClientsDto::fromArray([]),
            'metadata' => MetadataDto::fromArray([
                'ipv4_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]),
        ]);
    }
}
