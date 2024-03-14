<?php

declare(strict_types=1);

namespace App\Console\Commands\Auth;

use App\Dto\Models\Auth\CodeDto;
use App\Enums\Auth\Code\StatusEnum;
use App\Services\Api\V1\Auth\CodeService;
use Carbon\Carbon;
use Illuminate\Console\Command;

final class DisablingExpiredCodes extends Command
{
    protected $signature = 'auth:disabling-expired-codes';

    protected $description = 'Disabling expired codes';

    public function handle(CodeService $codeService): void
    {
        $count = 0;

        if ($codes = $codeService->all([
            'status' => StatusEnum::Unused->value,
            ['expires_at', '<', Carbon::now()->toDateTimeString()]
        ])) {
            /** @var CodeDto $code */
            foreach ($codes as $code) {
                $codeService->update([
                    'uuid' => $code->getUuid(),
                ], [
                    'status' => StatusEnum::Expired,
                    'revoked_at' => Carbon::now()->toDateTimeString(),
                ]);
                $count++;
            }

            $this->info('Disabling expired codes. / Count: '.$count);
        }
    }
}
