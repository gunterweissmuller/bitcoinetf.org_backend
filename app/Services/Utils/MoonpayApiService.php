<?php

declare(strict_types=1);

namespace App\Services\Utils;


use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class MoonpayApiService
{
    private PendingRequest $client;

    private string $publicKey;

    private string $privateKey;

    private mixed $walletAddress;


    public function __construct()
    {
        $this->client = Http::baseUrl(env('MOONPAY_HOST'));
        $this->publicKey = env('MOONPAY_PUBLIC_KEY');
        $this->privateKey = env('MOONPAY_SECRET');
        $this->walletAddress = env('BASIC_APOLLO_WALLET_POLYGON_USDT_ADDRESS');
    }

    /**
     * @param string $currencyCode
     * @return string
     */
    public function generateSignature(string $currencyCode)
    {
        $query = "?apiKey=$this->publicKey&currencyCode=$currencyCode&walletAddress=$this->walletAddress";
        $signature  = base64_encode(hash_hmac('sha256', $query, $this->privateKey, true));
        return env('MOONPAY_HOST') . $query . urlencode($signature);
    }
}
