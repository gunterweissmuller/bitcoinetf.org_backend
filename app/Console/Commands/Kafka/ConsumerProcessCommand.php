<?php

declare(strict_types=1);

namespace App\Console\Commands\Kafka;

use App\Enums\Kafka\ConsumerEnum;
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use Illuminate\Console\Command;
use Throwable;

final class ConsumerProcessCommand extends Command
{
    protected $signature = 'kafka:consumer-process';

    protected $description = 'Kafka | Consumer process';

    private string $topicName = 'optics';

    public function handle(): void
    {
        $conf = [
            'global' => [
                'client.id' => config('kafka.consumer_group_id').'_consumer',
                'group.id' => config('kafka.consumer_group_id').'_consumers',
                'metadata.broker.list' => config('kafka.brokers'),
                'enable.auto.commit' => 'false',
            ],
            'topic' => [
                'auto.offset.reset' => config('kafka.offset_reset'),
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

        $this->info('Started kafka messages consumer process!');

        $connection = new RdKafkaConnectionFactory($conf);

        $context = $connection->createContext();
        $queue = $context->createQueue($this->topicName);
        $consumer = $context->createConsumer($queue);

        while (true) {
            $message = $consumer->receive((int)config('kafka.consumer_timeout_ms'));

            if ($message) {
                dump($message->getKey(), $message->getProperties());

                if (in_array($message->getKey(), ConsumerEnum::cases())) {
                    $this->callGroup(
                        $message->getKey(),
                        $message->getBody(),
                        $message->getProperties(),
                        $message->getHeaders()
                    );
                }

                $consumer->acknowledge($message);
            }
        }
    }

    private function callGroup(string $key, string $body = null, array $properties = [], array $headers = []): void
    {
        try {
            $keys = explode('-', $key);
            $topicNameDir = ucfirst(str(str_replace('***', '', $this->topicName))->camel()->toString());
            $namespace = sprintf(
                'App\\Console\\Commands\\Kafka\\Controllers\\%s\\%sController',
                $topicNameDir,
                ucfirst($keys[0])
            );
            $action = str(implode('-', array_slice($keys, 1)))->camel()->toString();

            (new $namespace($key, $body, $properties, $headers))->$action();
        } catch (Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
