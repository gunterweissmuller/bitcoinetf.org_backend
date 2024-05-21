<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\MoonPaySignature;
use App\Http\Middleware\ApolloPaymentIp;
use App\Http\Middleware\ApolloPaymentSignature;
use App\Http\Middleware\CheckEnvironment;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Billing')
            ->prefix('billing')
            ->group(function () {

                /*
                 * /billing/shares/buy/init
                 * /billing/shares/payment/payment-methods
                 * /billing/shares/buy/apollopayment/check
                 * /billing/shares/buy/apollopayment/webhook
                 * /billing/shares/buy/moonpay/webhook
                 */
                Route::namespace('Shares')
                    ->prefix('shares')
                    ->group(function () {
                        Route::namespace('Payment')
                            ->prefix('payment')
                            ->group(function () {
                                Route::middleware(['auth'])->get('/payment-methods', 'PaymentController@getPaymentsMethods');
                                Route::middleware(['auth'])->post('/cancel-order', 'PaymentController@cancelOrder');
                            });
                        Route::namespace('Buy')
                            ->prefix('buy')
                            ->group(function () {
                                Route::middleware(['auth'])->post('/init', 'BuyController@init');
                                Route::namespace('Apollopayment')
                                    ->prefix('apollopayment')
                                    ->group(function () {
                                        Route::post('/webhook/{account_uuid}', 'ApollopaymentController@webhook')->middleware([ApolloPaymentIp::class, ApolloPaymentSignature::class]);
                                        Route::post('/mockWebhook/{account_uuid}', 'ApollopaymentController@mockWebhook')->middleware([CheckEnvironment::class]);
                                    });
                                // @fixme-v moonpay closed
                                Route::namespace('MoonPay')
                                    ->prefix('moonpay')
                                    ->group(function () {
                                        Route::post('/webhook', 'MoonPayController@webhook')->middleware([MoonPaySignature::class]);
                                    });
                            });
                    });

                /*
                * /billing/withdrawal/webhook
                */
                Route::prefix('withdrawal')
                    ->group(function () {
                        Route::post('/webhook/{withdrawal_uuid}', 'WithdrawalController@webhook')->middleware([ApolloPaymentIp::class, ApolloPaymentSignature::class]);
                        Route::get('/mock', 'WithdrawalController@mock')->middleware([CheckEnvironment::class]);

                        Route::post('/webhook-referral/{withdrawal_uuid}', 'WithdrawalController@webhookReferral')->middleware([ApolloPaymentIp::class, ApolloPaymentSignature::class]);
                        Route::get('/mock-referral-command', 'WithdrawalController@mockReferralCommand')->middleware([CheckEnvironment::class]);
                        Route::post('/mock-referral/{withdrawal_uuid}', 'WithdrawalController@mockWebhookReferral')->middleware([CheckEnvironment::class]);
                    });

            });
    });
