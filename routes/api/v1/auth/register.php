<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('register')
    ->group(function () {
        Route::post('/init', 'RegisterController@init');
        Route::post('/confirm', 'RegisterController@confirm');
        Route::get('/metamask', function () { return response()->json(['message' => 'I sign that I will use metamask for login to bitcoinetf.org'], 200); });
    });
