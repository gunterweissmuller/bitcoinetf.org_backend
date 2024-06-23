<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V3\Public\Billing\Shares\Buy;

use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V3\Public\Billing\Shares\Buy\InitPipelineDto;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Enums\Users\Account\OrderTypeEnum;
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
            'amount' => ['required', 'numeric', 'min:' . $globalService->getMinReplenishmentAmount()],
            'order_type' => ['required', 'string'],
            'check_discount' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): InitPipelineDto
    {
        $roundedAmount = (integer)round($this->get('amount'));
        $orderType = $this->get('order_type') ?? OrderTypeEnum::InitBTC->value;

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
                'order_type' => $orderType,
                'check_discount' => $this->get('check_discount'),
            ]),
        ]);
    }
}
