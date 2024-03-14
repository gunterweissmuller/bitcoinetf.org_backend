<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::namespace('App\Http\Controllers')
    ->group(function () {
        Route::namespace('Docs')
            ->prefix('docs')
            ->group(function () {
                Route::prefix('/swagger')
                    ->group(function () {
                        Route::get('/openapi-public.yaml', 'SwaggerController@public');
                        Route::get('/openapi-private.yaml', 'SwaggerController@private');
                        Route::get('/{type}', 'SwaggerController@swagger');
                    });
            });
    });
