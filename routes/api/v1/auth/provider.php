<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('provider')
    ->group(function () {
        Route::get('/google-auth/redirect-url', 'AuthController@redirectUrlToGoogleAuth');
        Route::get('/google-auth/init', 'AuthController@initGoogleAuth');
        Route::Post('/google-auth/confirm', 'AuthController@confirmGoogleAuth');
        Route::get('/metamask/message', 'RegisterController@metamaskMessage');
        Route::post('/metamask/init', 'RegisterController@metamaskInit');
        Route::post('/metamask/confirm', 'RegisterController@metamaskConfirm');
        Route::get('/apple-auth/redirect-url', 'AuthController@redirectUrlToAppleAuth');
        Route::get('/apple-auth/init', 'AuthController@initAppleAuth');
        Route::Post('/apple-auth/confirm', 'AuthController@confirmAppleAuth');
    });
