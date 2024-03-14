<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('News')
            ->prefix('news')
            ->group(function () {

                Route::prefix('sections')
                    ->group(function () {
                        Route::get('/', 'SectionController@list');
                        Route::get('/{uuid}', 'SectionController@get');
                    });

                Route::prefix('tags')
                    ->group(function () {
                        Route::get('/', 'TagController@list');
                        Route::get('/{uuid}', 'TagController@get');
                    });

                Route::prefix('articles')
                    ->group(function () {
                        Route::get('/', 'ArticleController@list');
                    });

                Route::prefix('article')
                    ->group(function () {
                        Route::get('/', 'ArticleController@get');
                    });

                Route::prefix('integration')
                    //->middleware(['auth'])
                    ->group(function () {
                        Route::get('/', 'IntegrationController@list');
                    });

            });
    });

Route::namespace('Private')
    ->prefix('private')
    ->middleware(['auth:editor'])
    ->group(function () {
        Route::namespace('News')
            ->prefix('news')
            ->group(function () {

                Route::prefix('integration')
                    ->group(function () {
                        Route::post('/', 'IntegrationController@create');
                        Route::get('/', 'IntegrationController@list');
                        Route::get('/{uuid}', 'IntegrationController@get');
                        Route::patch('/{uuid}', 'IntegrationController@update');
                        Route::delete('/{uuid}', 'IntegrationController@delete');
                    });

                Route::prefix('sections')
                    ->group(function () {
                        Route::post('/', 'SectionController@create');
                        Route::get('/', 'SectionController@list');
                        Route::get('/{uuid}', 'SectionController@get');
                        Route::patch('/{uuid}', 'SectionController@update');
                        Route::delete('/{uuid}', 'SectionController@delete');
                    });

                Route::prefix('tags')
                    ->group(function () {
                        Route::post('/', 'TagController@create');
                        Route::get('/', 'TagController@list');
                        Route::get('/{uuid}', 'TagController@get');
                        Route::patch('/{uuid}', 'TagController@update');
                        Route::delete('/{uuid}', 'TagController@delete');
                    });

                Route::prefix('articles')
                    ->group(function () {
                        Route::post('/', 'ArticleController@create');
                        Route::get('/', 'ArticleController@list');
                        Route::get('/{uuid}', 'ArticleController@get');
                        Route::patch('/{uuid}', 'ArticleController@update');
                        Route::delete('/{uuid}', 'ArticleController@delete');
                    });

            });
    });
