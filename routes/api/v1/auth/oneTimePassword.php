<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('one-time-password')
    ->group(function () {
        Route::post('/init', 'OneTimePasswordController@init');
        Route::post('/resend', 'OneTimePasswordController@resend');
    });
