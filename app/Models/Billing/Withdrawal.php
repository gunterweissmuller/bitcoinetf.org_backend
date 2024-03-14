<?php

declare(strict_types=1);

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Withdrawal extends Model
{
    use HasUuids;

    protected $table = 'billing.withdrawals';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'referral_wallet_uuid',
        'dividend_wallet_uuid',
        'referral_amount',
        'dividend_amount',
        'total_amount',
        'total_amount_btc',
        'btc_price',
        'wallet_address',
        'status',
    ];

    protected $casts = [
        'referral_amount' => 'float',
        'dividend_amount' => 'float',
        'total_amount' => 'float',
        'total_amount_btc' => 'float',
        'btc_price' => 'float',
    ];
}
