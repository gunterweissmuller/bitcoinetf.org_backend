<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Pap')
            ->prefix('pap')
            ->middleware('auth')
            ->group(function () {
                Route::post('/signup', 'PapController@signup');
                Route::post('/sale/tron', 'PapController@saleTron');
                Route::post('/sale/merchant001', 'PapController@saleMerchant001');
            });
    });
