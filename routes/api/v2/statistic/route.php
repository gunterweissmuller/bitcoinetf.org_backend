<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Statistic')
            ->prefix('statistic')
            ->group(function () {
                Route::get('/', 'StatisticController@general');
                Route::get('/flow', 'StatisticController@flow');
            });
    });
