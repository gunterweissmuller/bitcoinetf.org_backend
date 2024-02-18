<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::namespace('App\Http\Controllers\Api')
    ->group(function () {
        require_once 'api/v1/v1.php';
        require_once 'api/v2/v2.php';

    });
