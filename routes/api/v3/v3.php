<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('V3')
    ->prefix('v3')
    ->group(function () {
        require_once 'billing/route.php';
    });

