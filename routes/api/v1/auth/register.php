<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('register')
    ->group(function () {
        Route::post('/init', 'RegisterController@init');
        Route::post('/confirm', 'RegisterController@confirm');
        Route::get('/metamask', function () { return response()->json(['message' => 'Sign token zxcVbnm0123 using Metamask'], 200); });
    });
