<?php

declare(strict_types=1);

return [
    'brokers' => env('KAFKA_BROKERS', 'localhost:9092'),

    'consumer_group_id' => env('KAFKA_CONSUMER_GROUP_ID', 'group'),

    'consumer_timeout_ms' => env('KAFKA_CONSUMER_DEFAULT_TIMEOUT', 2000),

    'offset_reset' => env('KAFKA_OFFSET_RESET', 'latest'),

    'security_protocol' => env('KAFKA_SECURITY_PROTOCOL', 'SASL_PLAINTEXT'),

    'sasl_mechanism' => env('KAFKA_SASL_MECHANISM', 'SCRAM-SHA-512'),
    'sasl_username' => env('KAFKA_SASL_USERNAME'),
    'sasl_password' => env('KAFKA_SASL_PASSWORD'),
];
