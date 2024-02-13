<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::namespace('V1')
    ->prefix('v1')
    ->group(function () {
        require_once 'auth/route.php';
        require_once 'users/route.php';
        require_once 'news/route.php';
        require_once 'statistic/route.php';
        require_once 'kyc/route.php';
        require_once 'billing/route.php';
        require_once 'storage/route.php';
        require_once 'settings/route.php';
        require_once 'pages/route.php';
        require_once 'referrals/route.php';
        require_once 'newsletter/route.php';
    });
