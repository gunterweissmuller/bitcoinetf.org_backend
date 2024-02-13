<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Users')
            ->prefix('users')
            ->group(function () {
                Route::prefix('account')
                    ->middleware('auth')
                    ->group(function () {
                        Route::get('/me', 'AccountController@me');
                    });

                Route::prefix('profile')
                    ->middleware('auth')
                    ->group(function () {
                        Route::get('/me', 'ProfileController@me');
                    });
            });
    });

Route::namespace('Private')
    ->prefix('private')
    ->middleware(['auth:moderator'])
    ->group(function () {
        Route::namespace('Users')
            ->prefix('users')
            ->group(function () {
                Route::prefix('accounts')
                    ->group(function () {
                        Route::post('/', 'AccountController@create');
                        Route::get('/', 'AccountController@all');
                        Route::get('/{uuid}', 'AccountController@get');
                        Route::patch('/{uuid}', 'AccountController@update');
                        Route::delete('/{uuid}', 'AccountController@delete');
                    });
                Route::prefix('emails')
                    ->group(function () {
                        Route::get('/', 'EmailController@all');
                        Route::get('/{uuid}', 'EmailController@get');
                        Route::patch('/{uuid}', 'EmailController@update');
                    });
            });
    });
