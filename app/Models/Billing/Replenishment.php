<?php

declare(strict_types=1);

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Replenishment extends Model
{
    use HasUuids;

    protected $table = 'billing.replenishments';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'referral_wallet_uuid',
        'bonus_wallet_uuid',
        'dividend_wallet_uuid',
        'referral_amount',
        'bonus_amount',
        'dividend_amount',
        'dividend_btc_amount',
        'dividend_usdt_amount',
        'dividend_resp_amount',
        'real_amount',
        'total_amount',
        'total_amount_btc',
        'btc_price',
        'wallet_address',
        'status',
        'merchant001_id',
    ];

    protected $casts = [
        'referral_amount' => 'float',
        'bonus_amount' => 'float',
        'dividend_amount' => 'float',
        'dividend_btc_amount' => 'float',
        'dividend_usdt_amount' => 'float',
        'dividend_resp_amount' => 'float',
        'real_amount' => 'float',
        'selected_amount' => 'float',
        'added_amount' => 'float',
        'total_amount' => 'float',
        'total_amount_btc' => 'float',
        'btc_price' => 'float',
    ];
}
