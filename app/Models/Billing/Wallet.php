<?php

declare(strict_types=1);

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Wallet extends Model
{
    use HasUuids;

    protected $table = 'billing.wallets';

    protected $primaryKey = 'uuid';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    protected $fillable = [
        'account_uuid',
        'type',
        'amount',
        'withdrawal_address',
        'withdrawal_method',
    ];
}
