<?php

declare(strict_types=1);

namespace App\Services\Api\V3\Moonpay;

use App\Dto\Models\Moonpay\WebhooksDto;
use App\Repositories\Moonpay\Webhooks\WebhooksRepositoryInterface;
use App\Http\Requests\Api\V3\Public\Billing\Shares\Buy\MoonPayWebhookRequest;

final class MoonpayWebhooksService
{
    public function __construct(
        private readonly WebhooksRepositoryInterface $repository,
    )
    {
    }

    public function create(WebhooksDto $dto): WebhooksDto
    {
        return $this->repository->create($dto);
    }

    public function get(array $filters): ?WebhooksDto
    {
        return $this->repository->get($filters);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function delete(array $condition): void
    {
        $this->repository->delete($condition);
    }

    /**
     * @param MoonPayWebhookRequest $request
     * @return WebhooksDto
     */
    public function createMoonPayWebhookRecord(MoonPayWebhookRequest $request): WebhooksDto
    {
        $moon_pay_signature = $request->header('Moonpay-Signature-V2');
        $data = $request->all();
        $dto = new WebhooksDto(
            null,
            $clientId = $data['externalCustomerId'],
            $webhookId = $data['data']['id'],
            $addressId = $data['data']['cardId'],
            $amount = $data['data']['quoteCurrencyAmount'],
            $cryptoCurrencyCode = $data['data']['currency']['code'],
            env('MOONPAY_CURRENCY_NETWORK'),
            $tx = $data['data']['cryptoTransactionId'],
            $type = $data['data']['status'],
            null,
            null,
            json_encode($moon_pay_signature . json_encode($data, JSON_UNESCAPED_SLASHES), JSON_UNESCAPED_SLASHES),
        );
        return $this->repository->create($dto);
    }

}
