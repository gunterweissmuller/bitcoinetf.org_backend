<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Newsletter')
            ->prefix('newsletter')
            ->group(function () {

                Route::prefix('subscription')
                    ->group(function () {
                        Route::post('/subscribe', 'SubscriptionController@subscribe');
                    });

            });
    });
