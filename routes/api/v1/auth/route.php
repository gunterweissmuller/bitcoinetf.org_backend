<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')
    ->prefix('auth')
    ->group(function () {
        require_once 'register.php';
        require_once 'code.php';
        require_once 'login.php';
        require_once 'token.php';
        require_once 'recovery.php';
        require_once 'provider.php';
    });
