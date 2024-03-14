<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('V2')
    ->prefix('v2')
    ->group(function () {
        require_once 'statistic/route.php';
    });
