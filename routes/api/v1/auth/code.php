<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('code')
    ->group(function () {
        Route::post('/check', 'CodeController@check');
        Route::post('/resend', 'CodeController@resend');
    });
