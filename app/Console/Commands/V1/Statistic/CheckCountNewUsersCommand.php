<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Statistic;

use App\Services\Api\V1\Users\AccountService;
use App\Services\Utils\CentrifugalService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

final class CheckCountNewUsersCommand extends Command
{
    protected $signature = 'statistic:check-count-new-users';

    protected $description = 'Check count new users';

    public function handle(AccountService $accountService, CentrifugalService $centrifugalService): void
    {
        $before = Carbon::now()->subMinutes(10);

        $count = $accountService->countNewUsers($before->toDateTimeString(), Carbon::now()->toDateTimeString());

        if ($count > 0) {
            $centrifugalService->publish('event_header_info', [
                'type' => 'new_accounts',
                'count' => $count,
            ]);
        }
    }
}
