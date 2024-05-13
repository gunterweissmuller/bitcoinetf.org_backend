<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Billing')
            ->prefix('billing')
            ->group(function () {

                Route::prefix('credit-card/request')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::get('info', 'CreditCardRequestController@info');
                        Route::post('', 'CreditCardRequestController@create');
                    });

                Route::prefix('tokens')
                    //->middleware(['auth'])
                    ->group(function () {
                        Route::get('/', 'TokenController@list');
                        Route::get('/{uuid}', 'TokenController@get');
                    });

                /*
                 * /billing/shares/buy/init
                 * /billing/shares/buy/blockchain
                 * /billing/shares/buy/blockchain/tron/callback
                 * /billing/shares/buy/fiat
                 * /billing/shares/buy/fiat/merchant001/methods
                 * /billing/shares/buy/fiat/merchant001/payment
                 * /billing/shares/buy/fiat/merchant001/callback
                 */
                Route::namespace('Shares')
                    ->prefix('shares')
                    ->group(function () {

                        Route::namespace('Buy')
                            ->prefix('buy')
                            ->group(function () {
                                Route::middleware(['auth'])->post('/init', 'BuyController@init');

                                Route::namespace('Blockchain')
                                    ->prefix('blockchain')
                                    ->group(function () {
                                        Route::middleware(['auth'])->post('/tron/check',
                                            'TronController@check');
                                        Route::middleware(['auth:admin'])->post('/tron/callback',
                                            'TronController@callback');
                                    });

                                Route::namespace('Fiat')
                                    ->prefix('fiat')
                                    ->group(function () {
                                        Route::middleware(['auth'])
                                            ->get('/merchant001/methods', 'Merchant001Controller@methods');
                                        Route::middleware(['auth'])
                                            ->post('/merchant001/payment', 'Merchant001Controller@payment');
                                        Route::post('/merchant001/callback', 'Merchant001Controller@callback');
                                    });
                            });
                    });

                Route::prefix('withdrawal')
                    ->group(function () {
                        Route::middleware(['auth'])
                            ->get('/', 'WithdrawalController@list');
                        Route::middleware(['auth'])
                            ->post('/method', 'WithdrawalController@method');
                        // TODO: Отключен, но возможно в будущем понадобиться (логику не удалял)
//                        Route::middleware(['auth'])
//                            ->post('/dividends', 'WithdrawalController@dividends');
                        Route::middleware(['auth:admin'])
                            ->post('/dividends/callback', 'WithdrawalController@dividendsCallback');
                        Route::middleware(['auth'])
                            ->post('/referrals', 'WithdrawalController@referrals');
                        Route::middleware(['auth:admin'])
                            ->post('/referrals/callback', 'WithdrawalController@referralsCallback');
                    });

                Route::prefix('wallets')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::get('/', 'WalletController@all');
                        Route::get('/{type}', 'WalletController@get');
                    });

                Route::prefix('transactions')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::get('/', 'TransactionController@all');
                        Route::get('/{uuid}', 'TransactionController@get');
                    });

                Route::prefix('payment')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::get('/last', 'PaymentController@last');
                        Route::get('/statistic', 'PaymentController@statistic');
                        Route::get('/dividends/personal', 'PaymentController@personalDividends');
                        Route::get('/shares/personal', 'PaymentController@personalShares');
                        Route::get('/dividends/personal/period', 'PaymentController@personalDividendsByPeriod');
                    });

                Route::prefix('replenishment')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::get('/last', 'ReplenishmentController@last');
                        Route::get('/{uuid}', 'ReplenishmentController@get');
                    });

            });
    });

Route::namespace('Private')
    ->prefix('private')
    ->middleware(['auth:moderator'])
    ->group(function () {
        Route::namespace('Billing')
            ->prefix('billing')
            ->group(function () {

                Route::prefix('wallet')
                    ->group(function () {
                        Route::get('/', 'WalletController@list');
                    });

                Route::prefix('payment')
                    ->group(function () {
                        Route::get('/', 'PaymentController@list');
                    });

            });
    });
