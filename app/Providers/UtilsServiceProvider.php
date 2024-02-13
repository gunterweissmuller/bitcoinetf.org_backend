<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Utils\JWTService;
use Illuminate\Support\ServiceProvider;

final class UtilsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(JWTService::class, function () {
            return JWTService::getInstance();
        });
    }
}
