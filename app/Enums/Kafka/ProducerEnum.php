<?php

namespace App\Enums\Kafka;

enum ProducerEnum: string
{
    case AUTH_REGISTRATION = 'auth.registration';

    case BILLING_SHARES_BUY = 'billing.shares.buy';

    case BILLING_WALLETS_WITHDRAWAL = 'billing.wallets.withdrawal';

    case BILLING_SHARES_CLOSE = 'billing.shares.close';
}
