<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Public')
    ->prefix('public')
    ->group(function () {
        Route::namespace('Pages')
            ->prefix('pages')
            ->group(function () {

                Route::prefix('page')
                    ->group(function () {
                        Route::get('{slug}/{lang?}', 'PageController@get');
                    });

                Route::prefix('language')
                    ->group(function () {
                        Route::get('/', 'LanguageController@all');
                    });

            });
    });

Route::namespace('Private')
    ->prefix('private')
    ->middleware(['auth:editor'])
    ->group(function () {
        Route::namespace('Pages')
            ->prefix('pages')
            ->group(function () {

                Route::prefix('page')
                    ->group(function () {
                        Route::post('/', 'PageController@create');
                        Route::get('/', 'PageController@all');
                        Route::patch('/{id}', 'PageController@update');
                        Route::get('/{id}', 'PageController@get');
                        Route::delete('/{id}', 'PageController@delete');

                        Route::post('/{pageId}/section', 'SectionController@create');
                        Route::get('/{id}/section', 'SectionController@all');
                        Route::patch('/{pageId}/section/{sectionId}', 'SectionController@update');
                        Route::get('/{pageId}/section/{sectionId}', 'SectionController@get');
                        Route::delete('/{pageId}/section/{sectionId}', 'SectionController@delete');

                    });

                Route::prefix('section/template')
                    ->group(function () {
                        Route::post('/', 'SectionTemplateController@create');
                        Route::get('/', 'SectionTemplateController@all');
                        Route::patch('/{id}', 'SectionTemplateController@update');
                        Route::get('/{id}', 'SectionTemplateController@get');
                        Route::delete('/{id}', 'SectionTemplateController@delete');
                    });

                Route::prefix('language')
                    ->group(function () {
                        Route::post('/', 'LanguageController@create');
                        Route::get('/', 'LanguageController@all');
                        Route::patch('/{id}', 'LanguageController@update');
                        Route::get('/{id}', 'LanguageController@get');
                        Route::delete('/{id}', 'LanguageController@delete');
                    });

            });
    });
