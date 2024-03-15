<?php

declare(strict_types=1);


return [
    'iss' => env('JWT_ISS', env('APP_URL', 'auth.local')),

    'ttl' => [
        'access' => env('JWT_TTL_ACCESS', 420),
        'refresh' => env('JWT_TTL_REFRESH', 43200),
    ],
];
