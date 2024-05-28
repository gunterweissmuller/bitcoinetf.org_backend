<?php

declare(strict_types=1);

namespace app\Models\Billing;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Sell extends Model
{
    use HasUuids;

    protected $table = 'billing.sell';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'payment_uuid',
        'status',
        'period',
        'method',
        'destination',
        'value',
        'real_amount',
        'termination_fee',
        'transaction_fee',
        'return_all_paid',
    ];

    protected $casts = [
        'value' => 'float',
        'real_amount' => 'float',
        'termination_fee' => 'float',
        'transaction_fee' => 'float',
        'return_all_paid' => 'float',
    ];
}
