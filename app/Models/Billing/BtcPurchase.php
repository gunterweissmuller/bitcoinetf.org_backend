<?php

declare(strict_types=1);

namespace app\Models\Billing;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class BtcPurchase extends Model
{
    use HasUuids;

    protected $table = 'billing.btc_purchases';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'rate',
        'payments_updated',
        'amount',
    ];

    protected $casts = [
        'rate' => 'float',
        'payments_updated' => 'integer',
        'amount' => 'float',
    ];
}
