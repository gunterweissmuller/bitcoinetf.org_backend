<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('token')
    ->group(function () {
        Route::post('/refresh', 'TokenController@refresh');
    });
