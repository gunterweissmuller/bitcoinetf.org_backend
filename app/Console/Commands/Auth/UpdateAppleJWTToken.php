<?php

declare(strict_types=1);

namespace App\Console\Commands\Auth;

use App\Services\Utils\AppleAuthJWTService;
use Illuminate\Console\Command;

final class UpdateAppleJWTToken extends Command
{
    protected $signature = 'auth:update-apple-jwt-token';

    protected $description = 'Update Apple JWT token every 5 months';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('Updating Apple JWT token...');
        $message = AppleAuthJWTService::getInstance()->generateToken();
        $this->info($message);
    }
}
