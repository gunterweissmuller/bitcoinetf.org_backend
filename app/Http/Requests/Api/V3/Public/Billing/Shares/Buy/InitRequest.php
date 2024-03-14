<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Billing\Shares\Buy;

use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Http\Requests\AbstractRequest;
use App\Services\Api\V1\Settings\GlobalService;

final class InitRequest extends AbstractRequest
{
    public function rules(): array
    {
        /** @var GlobalService $globalService */
        $globalService = app(GlobalService::class);

        return [
            TypeEnum::DIVIDENDS->value => ['nullable', 'boolean'],
            TypeEnum::REFERRAL->value => ['nullable', 'boolean'],
            TypeEnum::BONUS->value => ['nullable', 'boolean'],
            'amount' => ['required', 'numeric', 'min:'.$globalService->getMinReplenishmentAmount()],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): InitPipelineDto
    {
        $roundedAmount = (integer)round($this->get('amount'));

        return InitPipelineDto::fromArray([
            ...$this->only([
                TypeEnum::DIVIDENDS->value,
                TypeEnum::REFERRAL->value,
                TypeEnum::BONUS->value,
            ]),
            'account' => AccountDto::fromArray($this->payload()->toArray()),
            'replenishment' => ReplenishmentDto::fromArray([
                'selected_amount' => $roundedAmount,
                'real_amount' => $roundedAmount,
            ]),
        ]);
    }
}
