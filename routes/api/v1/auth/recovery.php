<?php

declare(strict_types=1);

use App\Http\Middleware\CheckDemoUser;
use Illuminate\Support\Facades\Route;

Route::prefix('recovery')
    ->middleware([CheckDemoUser::class])
    ->group(function () {
        Route::post('/init', 'RecoveryController@init');
        Route::post('/check', 'RecoveryController@check');
        Route::post('/confirm', 'RecoveryController@confirm');
    });
