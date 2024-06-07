<?php

declare(strict_types=1);

use App\Http\Middleware\CheckEnvironment;
use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Statistic')
            ->prefix('statistic')
            ->group(function () {
                Route::get('/', 'StatisticController@general');
                Route::get('/flow', 'StatisticController@flow');
                Route::get('/mock-create-monthly-report-command', 'StatisticController@mockCreateMonthlyReportCommand')->middleware([CheckEnvironment::class]);
            });
    });
