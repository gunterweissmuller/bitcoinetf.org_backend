<?php

declare(strict_types=1);

namespace App\Services\Utils;


use App\Dto\Utils\ApollopaymentApi\CreateAsyncWithdrawalDto;
use App\Dto\Utils\ApollopaymentApi\CreateUserDto;
use App\Dto\Utils\ApollopaymentApi\GetCommissionWithdrawalDto;
use App\Dto\Utils\ApollopaymentApi\GetUserAddressDto;
use App\Dto\Utils\ApollopaymentApi\GetUserAllAddressesDto;
use App\Dto\Utils\ApollopaymentApi\GetUserDto;
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
     * @param GetUserDto $userData
     * @return array
     */
    public function getUser(GetUserDto $userData): array
    {
        return $this->post('/api-gateway/personal-addresses/get-user', $userData->toArray());
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
     * @param GetUserAllAddressesDto $data
     * @return array
     */
    public function getUserAllAddresses(GetUserAllAddressesDto $data): array
    {
        return $this->post('/api-gateway/personal-addresses/get-user-addresses', $data->toArray());
    }

    /**
     * @param GetCommissionWithdrawalDto $data
     * @return array
     */
    public function getCommissionWithdrawal(GetCommissionWithdrawalDto $data): array
    {
        return $this->post('/api-gateway/withdrawal-fee-token', $data->toArray());
    }

    /**
     * @param CreateAsyncWithdrawalDto $data
     * @return array
     */
    public function createAsyncWithdrawal(CreateAsyncWithdrawalDto $data): array
    {
        return $this->post('/api-gateway/make-withdrawal-async', $data->toArray());
    }

    /**
     * @param string $address
     * @return array
     */
    public function getBlockchainByAddress(string $address): array
    {
        return $this->post('/api-gateway/addresses/find-by-address', ['address' => $address]);
    }

    /**
     * @param string $address
     * @param string $blockchain
     * @return array
     */
    public function checkBlockchainAddress(string $address, string $blockchain): array
    {
        return $this->post('/api-gateway/utils/validate-address', ['address' => $address, 'network' => $blockchain]);
    }

    /**
     * @param string $url
     * @param array $data
     * @return array|null
     */
    private function post(string $url, array $data): ?array
    {
        $nonce = Carbon::now()->timestamp * 1000 + Carbon::now()->micro / 1000;
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
