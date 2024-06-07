<?php

declare(strict_types=1);

namespace App\Services\Api\V3\Apollopayment;


use App\Dto\Models\Apollopayment\ClientsDto;
use App\Dto\Utils\ApollopaymentApi\CreateUserDto;
use App\Dto\Utils\ApollopaymentApi\GetUserAllAddressesDto;
use App\Exceptions\Utils\Apollopayment\ApollopaymentUnavailableException;
use App\Services\Utils\ApollopaymentApiService;

final readonly class ApollopaymentService
{
    public function __construct(
        private ApollopaymentClientsService $apollopaymentClientsService,
        private ApollopaymentApiService     $apollopaymentApiService,
    )
    {
    }

    public function createUser(string $accountUuid, string $email, ?string $fullName, ?ClientsDto $apolloClient): void
    {
        if (!$this->apollopaymentClientsService->get([
            'account_uuid' => $accountUuid
        ])) {
            $apolloClient = $apolloClient ?? ClientsDto::fromArray([]);
            $webhookUrl = env('APP_URL') . "/v3/public/billing/shares/buy/apollopayment/webhook/" . $accountUuid;

            $userData = CreateUserDto::fromArray([
                'clientId' => $accountUuid,
                'clientEmail' => $email,
                'clientName' => $fullName ?? '',
                'depositWebhookUrl' => $webhookUrl,
            ]);

            $responseApolloUser = $this->apollopaymentApiService->createUser($userData);

            if ($responseApolloUser['success']) {

                $allAddresses = GetUserAllAddressesDto::fromArray(
                    [
                        'id' => $responseApolloUser['response']['id'],
                        'network' => ['ethereum', 'polygon', 'tron'],
                        'currency' => ['USDT'],
                    ]
                );

                $responseWalletAddresses = $this->apollopaymentApiService->getUserAllAddresses($allAddresses);

                if ($responseWalletAddresses['success']) {
                    $apolloClient->setAccountUuid($accountUuid);
                    $apolloClient->setClientId($responseApolloUser['response']['id']);

                    foreach ($responseWalletAddresses['response']['addresses'] as $walletAddress) {
                        switch ($walletAddress['network']) {
                            case 'ethereum':
                                $apolloClient->setEthereumAddr($walletAddress['address']);
                                break;
                            case 'tron':
                                $apolloClient->setTronAddr($walletAddress['address']);
                                break;
                            case 'polygon':
                                $apolloClient->setPolygonAddr($walletAddress['address']);
                                break;
                        }
                    }

                    $apolloClient->setWebhookUrl($webhookUrl);

                    $this->apollopaymentClientsService->create($apolloClient);
                } else {
                    throw new ApollopaymentUnavailableException('Cannot get wallets');
                }
            } else {
                throw new ApollopaymentUnavailableException('Can not create user');
            }
        }
    }
}
