<?php

declare(strict_types=1);

namespace App\Console\Commands\Auth;

use Illuminate\Console\Command;

final class UpdateAppleJWTToken extends Command
{
    protected $signature = 'auth:update-apple-jwt-token';

    protected $description = 'Update Apple JWT token every 5 months';

    //@todo-v create apple auth jwt service for update every 5 months
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('Updating Apple JWT token...');
//        code here

        $this->info('Apple JWT token updated successfully.');
    }
}
