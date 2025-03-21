<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\Apollopayment;

use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Http\Requests\AbstractRequest;
use App\Dto\Models\Apollopayment\WebhooksDto;
use App\Enums\Billing\Payment\ApolloPaymentWebhookTypeEnum;

class WebhookRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): CallbackPipelineDto
    {
        return CallbackPipelineDto::fromArray([
            'account' => AccountDto::fromArray([
                'uuid' => request()->account_uuid,
            ]),
            'replenishment' => ReplenishmentDto::fromArray([
                'real_amount' => (float)$this->get('amount'),
            ])
        ]);
    }

    public function webhook(): WebhooksDto
    {
        return WebhooksDto::fromArray([
            'client_id' => request()->account_uuid,
            'webhook_id' => $this->get('webhookId'),
            'address_id' => $this->get('addressId'),
            'amount' => (float)$this->get('amount'),
            'currency' => $this->get('currency'),
            'network' => $this->get('network'),
            'tx' => $this->get('tx'),
            'type' => ApolloPaymentWebhookTypeEnum::DEPOSIT->value,
        ]);
    }
}
