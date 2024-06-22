<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('register')
    ->group(function () {
        Route::post('/init', 'RegisterController@init');
        Route::post('/confirm', 'RegisterController@confirm');
        Route::post('/resend-pass', 'RegisterController@resendPassword');
    });
