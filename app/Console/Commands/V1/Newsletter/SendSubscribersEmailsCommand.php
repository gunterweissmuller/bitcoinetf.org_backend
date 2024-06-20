<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Newsletter;

use App\Dto\Models\Newsletter\SubscriptionDto;
use App\Jobs\V1\Newsletter\SendSubscriptionMailJob;
use App\Models\Newsletter\Subscription;
use App\Services\Api\V1\Newsletter\SubscriptionService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

final class SendSubscribersEmailsCommand extends Command
{
    private const COUNT = 10;

    protected $signature = 'newsletter:send-emails-to-subscribers';

    protected $description = 'Send emails to subscribers';

    public function handle(SubscriptionService $subscriptionService): void
    {
        $callback = function (Collection $items) {
            $items->map(function (Subscription $item) {
                $subscription = SubscriptionDto::fromArray($item->toArray());
                dispatch(new SendSubscriptionMailJob($subscription->getEmail()));
                Subscription::where('email', $subscription->getEmail())
                    ->update(['sent' => true]);
            });
        };

        $subscriptionService->allByFiltersWithChunk([
            ['sent', '=', false],
        ], self::COUNT, $callback);
    }
}
