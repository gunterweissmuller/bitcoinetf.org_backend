<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Referral')
            ->prefix('referral')
            ->group(function () {
                Route::prefix('code')
                    ->group(function () {
                        Route::post('/check', 'CodeController@check');
                    });
                Route::prefix('invite')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::post('/apply', 'InviteController@apply');
                    });
            });
    });

Route::namespace('Private')
    ->prefix('private')
    ->middleware(['auth:moderator'])
    ->group(function () {
        Route::namespace('Referrals')
            ->prefix('referrals')
            ->group(function () {
                Route::prefix('codes')
                    ->group(function () {
                        Route::get('/', 'CodeController@all');
                        Route::get('/{uuid}', 'CodeController@get');
                        Route::patch('/{uuid}', 'CodeController@update');
                    });
            });
    });
