<?php

declare(strict_types=1);


use App\Enums\Core\AppError\CodeEnum;

return [
    CodeEnum::C000000->value => 'i am a teapot',
    CodeEnum::C000001->value => 'not found',
    CodeEnum::C000002->value => 'validation error',
    CodeEnum::C010003->value => 'jwt not found',
    CodeEnum::C010004->value => 'jwt signature invalid',
    CodeEnum::C010005->value => 'jwt expired',
    CodeEnum::C010006->value => 'access forbidden',
    CodeEnum::C011001->value => 'username is already in use',
    CodeEnum::C011002->value => 'email is already in use',
    CodeEnum::C011003->value => 'email not found',
    CodeEnum::C011004->value => 'code cannot be resubmitted',
    CodeEnum::C011005->value => 'incorrect code',
    CodeEnum::C011006->value => 'incorrect login data',
    CodeEnum::C011007->value => 'incorrect refresh token',
    CodeEnum::C011008->value => 'incorrect login provider',
    CodeEnum::C011009->value => 'authorization token expired',
    CodeEnum::C011010->value => 'invalid signature',
    CodeEnum::C011011->value => 'user already exist',
    CodeEnum::C011012->value => 'incorrect password',
    CodeEnum::C020002->value => 'global symbol setup not found',
    CodeEnum::C030001->value => 'form not found',
    CodeEnum::C030002->value => 'screen not found',
    CodeEnum::C030003->value => 'form already passed',
    CodeEnum::C030004->value => 'screen already passed',
    CodeEnum::C040001->value => 'replenishment not available',
    CodeEnum::C040002->value => 'replenishment not found',
    CodeEnum::C050001->value => 'code not found',
    CodeEnum::C050002->value => 'already used code',
    CodeEnum::C060001->value => 'withdrawal is not possible',
    CodeEnum::C090001->value => 'file save error',
    CodeEnum::C100001->value => 'merchant001 unavailable',
    CodeEnum::C100002->value => 'this account pap tracker is already in use',
    CodeEnum::C100003->value => 'apollo payment unavailable',
];
