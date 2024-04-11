<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Statistic')
            ->prefix('statistic')
            ->group(function () {

                Route::get('/dividends', 'DividendController@get');

                Route::get('/', 'MainController@main');

                Route::get('/funds', 'FundController@main');

                Route::prefix('shareholders')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::get('/count', 'ShareholderController@count');
                        Route::get('/top', 'ShareholderController@top');
                        Route::get('/strategies', function () {
                            $strategies = [
                                ['name' => 'Tether', 'percent' => '67'],
                                ['name' => 'Bitcoin', 'percent' => '33']
                            ];
                            return response()->json($strategies);
                        });
                    });

                Route::prefix('report')
                    ->middleware(['auth'])
                    ->group(function () {
                        Route::get('/', 'ReportController@list');
                        Route::get('/{uuid}', 'ReportController@get');
                    });

            });
    });
