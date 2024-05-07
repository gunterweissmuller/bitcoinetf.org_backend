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
        Route::post('/metamask/login', 'LoginController@loginMetamask');
        Route::get('/apple/redirect-url', 'RegisterController@redirectUrlToAppleAuth');
        Route::post('/apple/get-auth-type', 'AuthController@getAuthTypeApple');
        Route::Post('/apple/init', 'RegisterController@initApple');
        Route::Post('/apple/confirm', 'RegisterController@confirmApple');
        Route::Post('/apple/login', 'LoginController@loginApple');
        Route::get('/telegram/credentials', 'RegisterController@getCredentialsTelegram');
        Route::post('/telegram/get-auth-type', 'AuthController@getAuthTypeTelegram');
        Route::post('/telegram/init', 'RegisterController@initTelegram');
        Route::post('/telegram/confirm', 'RegisterController@confirmTelegram');
        Route::post('/telegram/login', 'LoginController@loginTelegram');
        Route::get('/facebook/credentials', 'RegisterController@getCredentialsFacebook');
        Route::post('/facebook/get-auth-type', 'AuthController@getAuthTypeFacebook');
        Route::post('/facebook/init', 'RegisterController@initFacebook');
        Route::post('/facebook/confirm', 'RegisterController@confirmFacebook');
        Route::post('/facebook/login', 'LoginController@loginFacebook');
    });
