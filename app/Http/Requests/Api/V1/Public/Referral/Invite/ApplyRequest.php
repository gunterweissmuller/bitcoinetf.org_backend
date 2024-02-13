<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Referral\Invite;

use App\Dto\Models\Referrals\CodeDto;
use App\Dto\Models\Referrals\InviteDto;
use App\Dto\Pipelines\Api\V1\Public\Referral\Invite\ApplyPipelineDto;
use App\Http\Requests\AbstractRequest;

final class ApplyRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ApplyPipelineDto
    {
        $account = $this->payload();

        return ApplyPipelineDto::fromArray([
            'code' => CodeDto::fromArray(['code' => strtoupper($this->get('code'))]),
            'invite' => InviteDto::fromArray(['account_uuid' => $account->getUuid()]),
        ]);
    }
}
