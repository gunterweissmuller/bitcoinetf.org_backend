<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001;

use App\Dto\Models\Billing\ReplenishmentDto;
use App\Dto\Pipelines\Api\V1\Public\Billing\Shares\Buy\Fiat\Merchant001\CallbackPipelineDto;
use App\Dto\Utils\Merchant001\TransactionDto;
use App\Http\Requests\AbstractRequest;

final class CallbackRequest extends AbstractRequest
{
    public function rules(): array
    {
        // 'in:CREATED,PENDING,PAID,IN_PROGRESS,FAILED,EXPIRED,CANCELED,CONFIRMED'
        return [
            'status' => [
                'required',
                'string',
                'in:FAILED,EXPIRED,CANCELED,CONFIRMED'
            ],
            'signature' => ['required', 'string'],
            'transaction' => ['required', 'array'],
            'transaction.invoiceId' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function dto(): ?CallbackPipelineDto
    {
        return CallbackPipelineDto::fromArray([
            'transaction' => TransactionDto::fromArray([
                'id' => $this->get('transaction')['id'],
                'status' => $this->get('status'),
                'invoice_id' => $this->get('transaction')['invoiceId'],
                'amount' => $this->get('transaction')['pricing']['local']['amount'],
                'currency' => $this->get('transaction')['pricing']['local']['currency'],
                'signature' => $this->get('signature'),
            ]),
            'replenishment' => ReplenishmentDto::fromArray([
                'uuid' => $this->get('transaction')['invoiceId'],
            ]),
            'status' => strtolower($this->get('status')),
        ]);
    }
}
