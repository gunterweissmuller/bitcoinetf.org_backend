<?php

declare(strict_types=1);

namespace App\Services\Utils;

use App\Enums\Kafka\ProducerEnum;
use Enqueue\RdKafka\RdKafkaConnectionFactory;

final class KafkaProducerService
{
    public static function handle(
        ProducerEnum $key,
        string $body = null,
        array $properties = [],
        array $headers = []
    ): void
    {
        ini_set('default_socket_timeout', -1);

        $conf = [
            'global' => [
                'metadata.broker.list' => config('kafka.brokers'),
            ],
        ];

        if (!app()->isLocal()) {
            $conf['global'] = [
                ...$conf['global'],
                'security.protocol' => config('kafka.security_protocol'),
                'sasl.mechanism' => config('kafka.sasl_mechanism'),
                'sasl.username' => config('kafka.sasl_username'),
                'sasl.password' => config('kafka.sasl_password'),
            ];
        }

        $connection = new RdKafkaConnectionFactory($conf);

        $context = $connection->createContext();
        $topic = $context->createTopic('funds');
        $producer = $context->createProducer();

        $message = $context->createMessage(
            $body,
            $properties,
            $headers,
        );

        $message->setKey($key->value);

        $producer->send($topic, $message);
    }
}
