<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Kyc\Form;

use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V1\Public\Kyc\Form\GetPipelineDto;
use App\Http\Requests\AbstractRequest;

final class GetRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): GetPipelineDto
    {
        $account = $this->payload();

        return GetPipelineDto::fromArray([
            'account' => AccountDto::fromArray($account->toArray()),
        ]);
    }
}
