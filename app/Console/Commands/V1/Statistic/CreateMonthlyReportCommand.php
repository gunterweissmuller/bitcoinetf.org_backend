<?php

declare(strict_types=1);

namespace App\Console\Commands\V1\Statistic;

use App\Dto\Models\Users\AccountDto;
use App\Enums\Users\Account\SendMailEnum;
use App\Jobs\V1\Statistic\Report\StatementJob;
use App\Models\Users\Account;
use App\Services\Api\V1\Users\AccountService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class CreateMonthlyReportCommand extends Command
{
    private const COUNT = 400;

    protected $signature = 'statistic:create-monthly-report';

    protected $description = 'Создание ежемесячных отчет по аккаунтам';

    public function handle(AccountService $accountService): void
    {
        $start = (new Carbon('first day of last month'))->toDateString();
        $end = (new Carbon('last day of last month'))->toDateString();

        $callback = function (Collection $items) use ($start, $end) {
            $items->map(function (Account $item) use ($start, $end) {
                $account = AccountDto::fromArray($item->toArray());

                dispatch(new StatementJob($account->getUuid(), $start, $end));
            });
        };

        $accountService->allByFiltersWithChunk([
            ['send_mail', '=', SendMailEnum::Yes->value],
        ], self::COUNT, $callback);
    }
}
