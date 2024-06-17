<?php

declare(strict_types=1);

use App\Http\Middleware\CheckDemoUser;
use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->middleware(['auth', CheckDemoUser::class])
    ->group(function () {
        Route::namespace('Kyc')
            ->prefix('kyc')
            ->group(function () {

                Route::prefix('forms')
                    ->group(function () {
                        Route::get('/', 'FormController@get');
                    });

                Route::prefix('screens')
                    ->group(function () {
                        Route::get('/', 'ScreenController@all');
                    });

                Route::prefix('screen')
                    ->group(function () {
                        Route::get('/', 'ScreenController@get');
                        Route::get('/states', 'ScreenController@states');
                        Route::post('/', 'ScreenController@save');
                    });

            });
    });

Route::namespace('Private')
    ->prefix('private')
    ->middleware(['auth:editor'])
    ->group(function () {
        Route::namespace('Kyc')
            ->prefix('kyc')
            ->group(function () {

                Route::prefix('forms')
                    ->group(function () {
                        Route::post('/', 'FormController@create');
                        Route::get('/', 'FormController@list');
                        Route::get('/{uuid}', 'FormController@get');
                        Route::patch('/{uuid}', 'FormController@update');
                        Route::delete('/{uuid}', 'FormController@delete');
                    });

                Route::prefix('screens')
                    ->group(function () {
                        Route::post('/', 'ScreenController@create');
                        Route::get('/', 'ScreenController@list');
                        Route::get('/{uuid}', 'ScreenController@get');
                        Route::patch('/{uuid}', 'ScreenController@update');
                        Route::delete('/{uuid}', 'ScreenController@delete');
                    });

                Route::prefix('fields/options')
                    ->group(function () {
                        Route::post('/', 'FieldOptionController@create');
                        Route::get('/', 'FieldOptionController@list');
                        Route::get('/{uuid}', 'FieldOptionController@get');
                        Route::patch('/{uuid}', 'FieldOptionController@update');
                        Route::delete('/{uuid}', 'FieldOptionController@delete');
                    });

                Route::prefix('fields')
                    ->group(function () {
                        Route::post('/', 'FieldController@create');
                        Route::get('/', 'FieldController@list');
                        Route::get('/{uuid}', 'FieldController@get');
                        Route::patch('/{uuid}', 'FieldController@update');
                        Route::delete('/{uuid}', 'FieldController@delete');
                    });

                Route::prefix('sessions/results')
                    ->group(function () {
                        Route::get('/', 'SessionResultController@list');
                        Route::get('/{uuid}', 'SessionResultController@get');
                        Route::patch('/{uuid}', 'SessionResultController@update');
                        Route::delete('/{uuid}', 'SessionResultController@delete');
                    });

                Route::prefix('sessions')
                    ->group(function () {
                        Route::get('/', 'SessionController@list');
                        Route::get('/{uuid}', 'SessionController@get');
                        Route::patch('/{uuid}', 'SessionController@update');
                        Route::delete('/{uuid}', 'SessionController@delete');
                    });

            });
    });
