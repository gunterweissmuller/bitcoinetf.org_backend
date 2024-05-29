<?php

declare(strict_types=1);

namespace App\Enums\Billing\Payment;

use App\Enums\InteractWithEnum;

enum TypeEnum: string
{
    use InteractWithEnum;

    case DEBIT_TO_CLIENT = 'debit_to_client'; // Любые пополнения

    case CREDIT_FROM_CLIENT = 'credit_from_client'; // Любые списывания

    case WITHDRAWAL = 'withdrawal'; // Вывод

    case SELL = 'sell'; // Продажа
}
