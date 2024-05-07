<?php

declare(strict_types=1);

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Payment extends Model
{
    use HasUuids;

    protected $table = 'billing.payments';

    protected $primaryKey = 'uuid';

    protected array $dates = [
        'created_at',
        'updated_at',
        'payday',
    ];

    protected $casts = [
        'referral_amount' => 'float',
        'bonus_amount' => 'float',
        'dividend_amount' => 'float',
        'vault_amount' => 'float',
        'selected_amount' => 'float',
        'real_amount' => 'float',
        'added_amount' => 'float',
        'total_amount_btc' => 'float',
        'btc_price' => 'float',
    ];

    protected $fillable = [
        'account_uuid',
        'referral_wallet_uuid',
        'bonus_wallet_uuid',
        'dividend_wallet_uuid',
        'vault_wallet_uuid',
        'referral_amount',
        'bonus_amount',
        'dividend_amount',
        'vault_amount',
        'selected_amount',
        'real_amount',
        'added_amount',
        'type',
        'total_amount_btc',
        'btc_price',
        'withdrawal_method',
        'desc_type',
        'payday',
        'code_uuid',
        'created_at',
        'updated_at',
    ];
}
