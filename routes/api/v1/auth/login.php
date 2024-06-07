<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('login')
    ->group(function () {
        Route::post('/', 'LoginController@login');
        Route::post('/demo', 'LoginController@loginDemo');
        Route::post('/one-time-pass', 'LoginController@loginOneTimePass');
    });
