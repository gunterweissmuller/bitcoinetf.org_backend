<?php

declare(strict_types=1);

namespace App\Services\Utils;


use App\Dto\Utils\ApollopaymentApi\CreateUserDto;
use App\Dto\Utils\ApollopaymentApi\GetUserAddressDto;
use App\Exceptions\Utils\Apollopayment\ApollopaymentUnavailableException;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class ApollopaymentApiService
{
    private PendingRequest $client;

    private string $publicKey;

    private string $privateKey;


    public function __construct()
    {
        $this->client = Http::baseUrl(env('APOLLO_PAYMENT_HOST'));
        $this->publicKey = env('APOLLO_PAYMENT_PUBLIC_KEY');
        $this->privateKey = env('APOLLO_PAYMENT_PRIVATE_KEY');
    }

    /**
     * @param CreateUserDto $userData
     * @return array
     */
    public function createUser(CreateUserDto $userData): array
    {
        return $this->post('/api-gateway/personal-addresses/create-user', $userData->toArray());
    }

    /**
     * @param GetUserAddressDto $data
     * @return array
     */
    public function getUserAddress(GetUserAddressDto $data): array
    {
        return $this->post('/api-gateway/personal-addresses/get-user-address', $data->toArray());
    }

    /**
     * @param string $url
     * @param array $data
     * @return array|null
     */
    private function post(string $url, array $data): ?array
    {
        $nonce = Carbon::now()->timestamp;
        $data['nonce'] = $nonce;
        $stringPayload = json_encode($data);
        $this->addHeaders($stringPayload);

        try {
            return $this->client->post($url, $data)
                ->throw()
                ->json();
        } catch (Exception $exception) {
            throw new ApollopaymentUnavailableException($exception->getMessage());
        }
    }

    /**
     * @param string $stringPayload
     * @return void
     */
    private function addHeaders(string $stringPayload): void
    {
        $hashedPayload = hash_hmac('sha256', $stringPayload, $this->privateKey);
        $this->client->replaceHeaders([
            'x-api-public-key' => $this->publicKey,
            'x-api-signature' => $hashedPayload,
        ]);
    }
}
