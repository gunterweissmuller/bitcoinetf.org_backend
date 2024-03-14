<?php

declare(strict_types=1);

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class Token extends Model
{
    use HasUuids;

    protected $table = 'billing.tokens';

    protected $primaryKey = 'uuid';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    protected $fillable = [
        'name',
        'symbol',
        'amount',
    ];
}
