<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('register')
    ->group(function () {
        Route::post('/init', 'RegisterController@init');
        Route::post('/confirm', 'RegisterController@confirm');
        Route::get('/metamask/message', 'RegisterController@metamaskMessage');
        Route::post('/metamask/init', 'RegisterController@metamaskInit');
        Route::post('/metamask/confirm', 'RegisterController@metamaskConfirm');
    });
