<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApolloPaymentIp;
use App\Http\Middleware\ApolloPaymentSignature;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Billing')
            ->prefix('billing')
            ->group(function () {

                /*
                 * /billing/shares/buy/init
                 * /billing/shares/buy/apollopayment/methods
                 * /billing/shares/buy/apollopayment/check
                 * /billing/shares/buy/apollopayment/webhook
                 */
                Route::namespace('Shares')
                    ->prefix('shares')
                    ->group(function () {
                        Route::namespace('Buy')
                            ->prefix('buy')
                            ->group(function () {
                                Route::middleware(['auth'])->post('/init', 'BuyController@init');
                                Route::namespace('Apollopayment')
                                    ->prefix('apollopayment')
                                    ->group(function () {
                                        Route::middleware(['auth'])->get('/methods', 'ApollopaymentController@methods');
                                        Route::middleware(['auth'])->post('/check', 'ApollopaymentController@check');
                                        Route::post('/webhook/{account_uuid}', 'ApollopaymentController@webhook')->middleware([ApolloPaymentIp::class, ApolloPaymentSignature::class]);
                                    });
                            });
                    });
            });
    });
