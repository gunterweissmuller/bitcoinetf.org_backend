<?php

declare(strict_types=1);

namespace App\Enums\Billing\Payment;

use App\Enums\InteractWithEnum;

enum ApolloPaymentDepositStatusEnum: string
{
    use InteractWithEnum;

    case PENDING = 'PENDING';

    case PROCESSED = 'PROCESSED';
}
