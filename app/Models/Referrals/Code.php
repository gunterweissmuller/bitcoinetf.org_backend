<?php

declare(strict_types=1);

namespace App\Models\Referrals;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Code extends Model
{
    use HasUuids;

    protected $table = 'referrals.codes';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'code',
        'increased_minimum_apy',
        'status',
    ];

    protected $casts = [
        'increased_minimum_apy' => 'float',
    ];
}
