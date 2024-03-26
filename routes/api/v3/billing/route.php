<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Billing')
            ->prefix('billing')
            ->group(function () {

                /*
                 * /billing/shares/payment/payment-methods
                 */
                Route::namespace('Shares')
                    ->prefix('shares')
                    ->group(function () {
                        Route::namespace('Payment')
                            ->prefix('payment')
                            ->group(function () {
                                Route::middleware(['auth'])->get('/payment-methods', 'PaymentController@getPaymentsMethods');
                            });
                        Route::namespace('Buy')
                            ->prefix('buy')
                            ->group(function () {
                                Route::namespace('MoonPay')
                                    ->prefix('moonpay')
                                    ->group(function () {
                                        Route::post('/webhook', 'MoonPayController@webhook')->middleware([MoonPaySignature::class]);
                                    });
                            });
                    });
            });
    });

