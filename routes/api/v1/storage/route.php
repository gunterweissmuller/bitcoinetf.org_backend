<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->middleware(['auth'])
    ->group(function () {
        Route::namespace('Storage')
            ->prefix('storage')
            ->group(function () {

                Route::prefix('file')
                    ->group(function () {

                        Route::post('/upload', 'FileController@upload');

                    });

            });
    });

Route::namespace('Private')
    ->prefix('private')
    ->middleware(['auth:moderator'])
    ->group(function () {
        Route::namespace('Storage')
            ->prefix('storage')
            ->group(function () {

                Route::prefix('file')
                    ->group(function () {
                        Route::post('/', 'FileController@upload');

                    });
            });
    });
