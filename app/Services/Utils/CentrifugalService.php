<?php

declare(strict_types=1);

namespace App\Services\Utils;

use phpcent\Client;

final class CentrifugalService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(config('centrifugal.host'));
        $this->client->setApiKey(config('centrifugal.api_key'));
    }

    public function publish(string $channel, array $message): void
    {
        $this->client->publish($channel, ['message' => $message]);
    }

    public function getToken(string $accountUuid, int $expiredAtInUnixTime): string
    {
        return $this->client
            ->setSecret(config('centrifugal.secret_key'))
            ->generateConnectionToken($accountUuid, $expiredAtInUnixTime);
    }
}
