<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Http\Requests\AbstractRequest;
use App\Services\Api\V1\Settings\GlobalService;

class WebhookRequest extends AbstractRequest
{
    public function rules(): array
    {
//        /** @var GlobalService $globalService */
//        $globalService = app(GlobalService::class);

        return [
//            'account_uuid' => ['required', 'uuid', 'exists:App\Models\Users\Account,uuid'],
//            'amount' => ['required', 'numeric', 'min:' . $globalService->getMinReplenishmentAmount()],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): CallbackPipelineDto
    {
        return CallbackPipelineDto::fromArray([
            'account' => AccountDto::fromArray([
                'uuid' => request()->account_uuid,//TODO add validation
            ]),
            'replenishment' => ReplenishmentDto::fromArray([
                'real_amount' => (float)$this->get('amount'),
            ])
        ]);
    }
}
