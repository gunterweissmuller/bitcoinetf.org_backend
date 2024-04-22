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

    private string $redirectUrl;

    public function __construct()
    {
        $this->client = Http::baseUrl(env('MOONPAY_HOST'));
        $this->publicKey = env('MOONPAY_PUBLIC_KEY');
        $this->privateKey = env('MOONPAY_SECRET');
        $this->walletAddress = env('APOLLO_PAYMENT_BASIC_WALLET_POLYGON_USDT_ADDRESS');
        $this->redirectUrl = env('MOONPAY_REDIRECT_URL');
    }

    /**
     * @param string $currencyCode
     * @param string $baseCurrencyAmount
     * @param string $externalTransactionId
     * @param string $externalCustomerId
     * @return string
     */
    public function generateUrlWithSignature(
        string $currencyCode,
        string $baseCurrencyAmount,
        string $externalTransactionId,
        string $externalCustomerId
        ) : string
    {
        $redirectLink = urlencode($this->redirectUrl);
        $query = "?apiKey=$this->publicKey";
        $query .= "&currencyCode=$currencyCode";
        $query .= "&walletAddress=$this->walletAddress";
        $query .= "&baseCurrencyCode=usd";
        $query .= "&baseCurrencyAmount=$baseCurrencyAmount";
        $query .= "&lockAmount=true";
        $query .= "&externalTransactionId=$externalTransactionId";
        $query .= "&externalCustomerId=$externalCustomerId";
        $query .= "&redirectURL=$redirectLink";
        $query .= "&showWalletAddressForm=false";
        $signature  = base64_encode(hash_hmac('sha256', $query, $this->privateKey, true));
        return env('MOONPAY_HOST') . $query . "&signature=" . urlencode($signature);
    }
}
