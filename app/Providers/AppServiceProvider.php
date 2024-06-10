<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (app()->isLocal()) {
            Log::channel('sql')->info(str_pad('', 20, '-'));

            DB::listen(function ($query) {
                Log::channel('sql')->info($query->time, [
                    'query' => $query->sql,
                    'bindings' => $query->bindings,
                ]);
            });
        }
    }

    public function boot(): void
    {
        Gate::define('readonly', function ($user) {
            return $user->uuid !== env('DEMO_ACCOUNT_UUID', '9c1c257f-2ea5-4da1-a12b-f0a5b980edae');
        });
    }
}
