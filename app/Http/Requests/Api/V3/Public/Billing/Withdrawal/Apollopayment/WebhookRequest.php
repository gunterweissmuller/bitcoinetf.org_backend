<?php

declare(strict_types=1);

namespace app\Http\Requests\Api\V3\Public\Billing\Withdrawal\Apollopayment;


use App\Dto\Models\Billing\WithdrawalDto;
use App\Dto\Models\Users\AccountDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Blockchain\Tron\CallbackPipelineDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Withdrawal\DividendPipelineDto;
use App\Enums\Billing\Wallet\TypeEnum;
use App\Enums\Billing\Withdrawal\MethodEnum;
use App\Http\Requests\AbstractRequest;
use App\Services\Api\V1\Settings\GlobalService;
use App\Dto\Models\Apollopayment\WebhooksDto;
use App\Enums\Billing\Payment\ApolloPaymentWebhookTypeEnum;
use App\Enums\Billing\Withdrawal\StatusEnum;

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
                'uuid' => request()->account_uuid,//TODO add validation
            ]),
        ]);
    }

    public function webhook(): WebhooksDto
    {
        return WebhooksDto::fromArray([
            'client_id' => request()->withdrawal_uuid,
            'webhook_id' => $this->get('webhookId'),
            'address_id' => $this->get('addressId'),
            'amount' => (float)$this->get('amount'),
            'currency' => $this->get('currency'),
            'network' => $this->get('network'),
            'tx' => $this->get('tx'),
            'type' => ApolloPaymentWebhookTypeEnum::WITHDRAW->value,
        ]);
    }

    public function dividendPipelineDto(): DividendPipelineDto
    {
        return DividendPipelineDto::fromArray([
            'withdrawal' => WithdrawalDto::fromArray([
                'uuid' => request()->withdrawal_uuid,
                'dividend_amount' => (float)$this->get('amount'),
                'total_amount' => (float)$this->get('amount'),
                'wallet_address' => $this->get('addressTo'),
                'status' => StatusEnum::SUCCESS->value,
            ]),
            'method' => MethodEnum::POLYGON_USDT->value,
        ]);
    }
}
