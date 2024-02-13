<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Kyc\Screen;

use App\Dto\Models\Kyc\FormDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Screen\AllPipelineDto;
use App\Http\Requests\AbstractRequest;

final class AllRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'form_uuid' => ['required', 'uuid'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): AllPipelineDto
    {
        $account = $this->payload();

        return AllPipelineDto::fromArray([
            'account' => AccountDto::fromArray($account->toArray()),
            'form' => FormDto::fromArray([
                'uuid' => $this->get('form_uuid')
            ])
        ]);
    }
}
