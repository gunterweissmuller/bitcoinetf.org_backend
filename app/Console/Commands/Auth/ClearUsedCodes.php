<?php

declare(strict_types=1);

namespace App\Console\Commands\Auth;

use App\Dto\Models\Auth\CodeDto;
use App\Enums\Auth\Code\StatusEnum;
use App\Services\Api\V1\Auth\CodeService;
use Illuminate\Console\Command;

final class ClearUsedCodes extends Command
{
    protected $signature = 'auth:clear-used-codes';

    protected $description = 'Clear used codes';

    public function handle(CodeService $codeService): void
    {
        $count = 0;

        if ($codes = $codeService->all(['status' => StatusEnum::Used->value])) {
            /** @var CodeDto $code */
            foreach ($codes as $code) {
                $codeService->delete(['uuid' => $code->getUuid()]);
                $count++;
            }
        }

        $this->info('Clear used codes. / Count: '.$count);
    }
}
