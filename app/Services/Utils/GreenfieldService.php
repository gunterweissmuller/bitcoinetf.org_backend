<?php

declare(strict_types=1);

namespace App\Services\Utils;

use App\Dto\Pipelines\Utils\Greenfield\CreateLightningInvoiceDto;
use App\Dto\Pipelines\Utils\Greenfield\CreatePayLightningInvoiceDto;
use App\Dto\Pipelines\Utils\Greenfield\LightningInvoiceDto;
use App\Dto\Pipelines\Utils\Greenfield\PayLightningInvoiceDto;
use App\Dto\Pipelines\Utils\Greenfield\PayoutDto;
use App\Dto\Pipelines\Utils\Greenfield\PullPaymentDto;
use App\Exceptions\Utils\Greenfield\GreenfieldQueryError;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class GreenfieldService
{
    private string $storeId;

    private PendingRequest $client;

    public function __construct()
    {
        $this->storeId = env('GREENFIELD_STORE_ID');

        $this->client = Http::baseUrl(env('GREENFIELD_HOST').'/api')->withHeaders([
            'Authorization' => 'token '.env('GREENFIELD_API_KEY'),
        ]);
    }

    public function getPullPayments(): array
    {
        $url = '/v1/stores/'.$this->storeId.'/pull-payments';

        $pullPayments = $this->get($url);

        $result = [];
        foreach ($pullPayments as $pullPayment) {
            $pullPayment['amount'] = (float) $pullPayment['amount'];
            $result[] = PullPaymentDto::fromArray($pullPayment);
        }

        return $result;
    }

    public function createPullPayment(PullPaymentDto $dto, $paymentMethods = ['BTC-OnChain', 'BTC-LightningLike']): PullPaymentDto
    {
        $url = '/v1/stores/'.$this->storeId.'/pull-payments';

        $pullPayment = $this->post($url, [
            ...$dto->toArray(),
            'paymentMethods' => $paymentMethods,
        ]);

        $pullPayment['amount'] = (float) $pullPayment['amount'];

        return PullPaymentDto::fromArray($pullPayment);
    }

    public function createPayouts(string $pullPaymentId, PayoutDto $dto): PayoutDto
    {
        $url = '/v1/pull-payments/'.$pullPaymentId.'/payouts';

        $payout = $this->post($url, [
            'destination' => $dto->getDestination(),
            'amount' => $dto->getAmount(),
            'paymentMethod' => $dto->getPaymentMethod(),
        ]);

        $payout['amount'] = (float) $payout['amount'];
        $payout['paymentMethodAmount'] = (float) $payout['paymentMethodAmount'];

        return PayoutDto::fromArray($payout);
    }

    public function createLightningInvoice(CreateLightningInvoiceDto $dto, $cryptoCode = 'BTC'): LightningInvoiceDto
    {
        $url = '/v1/server/lightning/'.$cryptoCode.'/invoices';

        $lightningInvoice = $this->post($url, $dto->toArray());

        $lightningInvoice['paidAt'] = (int) $lightningInvoice['paidAt'];
        $lightningInvoice['expiresAt'] = (int) $lightningInvoice['expiresAt'];

        return LightningInvoiceDto::fromArray($lightningInvoice);
    }

    public function createPayLightningInvoice(
        CreatePayLightningInvoiceDto $dto,
        string $cryptoCode = 'BTC',
    ): PayLightningInvoiceDto {
        $url = '/v1/server/lightning/'.$cryptoCode.'/invoices/pay';

        $lightningInvoiceDto = $this->post($url, $dto->toArray());

        $lightningInvoiceDto['createdAt'] = (int) $lightningInvoiceDto['createdAt'];

        return PayLightningInvoiceDto::fromArray($lightningInvoiceDto);
    }

    private function get(string $url): ?array
    {
        try {
            return $this->client->get($url)
                ->throw()
                ->json();
        } catch (Exception $exception) {
            throw new GreenfieldQueryError();
        }
    }

    private function post(string $url, array $data): ?array
    {
        try {
            return $this->client->post($url, $data)
                ->throw()
                ->json();
        } catch (Exception $exception) {
            dump($exception->getMessage());
            Log::error($exception->getMessage());
            throw new GreenfieldQueryError();
        }
    }
}
