<?php

declare(strict_types=1);

namespace App\Models\Statistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class DailyWallet extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $table = 'statistics.daily_wallets';

    protected $primaryKey = 'uuid';

    protected $dates = [
        'created_at',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    protected $fillable = [
        'account_uuid',
        'type',
        'amount',
        'created_at',
    ];
}
