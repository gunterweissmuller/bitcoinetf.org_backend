<?php

declare(strict_types=1);

namespace App\Console\Commands\Docs\Swagger;

use App\Services\Docs\Swagger\BundlerService;
use Illuminate\Console\Command;

final class SwaggerBuildCommand extends Command
{
    protected $signature = 'docs:swagger-build';

    protected $description = "Collects the resulting dock files from the source in the swagger folder in .yaml format";

    public function handle(BundlerService $bundlerService): void
    {
        $bundlerService->build(
            BundlerService::VERSION_V1,
            BundlerService::PUBLIC_REALMS,
        );

        $bundlerService->build(
            BundlerService::VERSION_V1,
            BundlerService::PRIVATE_REALMS,
        );

        $this->info('The final documentation file was successfully collected!');
    }
}
