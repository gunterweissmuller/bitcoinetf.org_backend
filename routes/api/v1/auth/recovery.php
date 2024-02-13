<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('recovery')
    ->group(function () {
        Route::post('/init', 'RecoveryController@init');
        Route::post('/check', 'RecoveryController@check');
        Route::post('/confirm', 'RecoveryController@confirm');
    });
