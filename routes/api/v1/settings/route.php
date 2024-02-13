<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Private')
    ->prefix('private')
    ->middleware(['auth:admin'])
    ->group(function () {
        Route::namespace('Settings')
            ->prefix('settings')
            ->group(function () {

                Route::prefix('globals')
                    ->group(function () {
                        Route::get('/', 'GlobalController@all');
                        Route::get('/{symbol}', 'GlobalController@get');
                        Route::patch('/', 'GlobalController@update');
                    });

            });
    });
