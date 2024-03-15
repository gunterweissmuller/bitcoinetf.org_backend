<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Pap')
            ->prefix('pap')
            ->middleware('auth')
            ->group(function () {
                Route::post('/signup', 'PapController@signup');
            });
    });
