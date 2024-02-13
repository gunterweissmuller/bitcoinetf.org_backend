<?php

declare(strict_types=1);

namespace App\Services\Utils;

use App\Exceptions\Utils\Merchant001\Merchant001UnavailableException;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class Merchant001Service
{
    private PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::baseUrl(env('MERCHANT001_HOST'))
            ->withHeaders([
                'Authorization' => 'Bearer '.env('MERCHANT001_API_TOKEN'),
                //'Content-Type' => 'application/x-www-form-urlencoded',
            ]);
    }

    public function health()
    {
        $url = '/v1/healthcheck/merchant';

        return $this->get($url);
    }

    public function paymentMethods(?float $amount = null): array
    {
        $url = '/v2/payment-method/merchant/available?makeArray=1';

        if ($amount) {
            $url .= '&amount='.$amount;
        }

        return $this->get($url);
    }

    public function rate(?string $method = 'rub_sbp'): array
    {
        $url = '/v1/rate?method='.$method;

        return $this->get($url);
    }

    public function createTransaction(float $amount, string $method, string $invoiceId): array
    {
        $url = '/v1/transaction/merchant';

        return $this->post($url, [
            'isPartnerFee' => true,
            'pricing' => [
                'local' => [
                    'amount' => $amount,
                    'currency' => 'RUB',
                ],
            ],
            'selectedProvider' => [
                'method' => $method,
            ],
            'invoiceId' => $invoiceId,
        ]);
    }

    private function get(string $url): ?array
    {
        try {
            return $this->client->get($url)
                ->throw()
                ->json();
        } catch (Exception $exception) {
            throw new Merchant001UnavailableException($exception->getMessage());
        }
    }

    private function post(string $url, array $data): ?array
    {
        try {
            return $this->client->post($url, $data)
                ->throw()
                ->json();
        } catch (Exception $exception) {
            throw new Merchant001UnavailableException($exception->getMessage());
        }
    }
}
