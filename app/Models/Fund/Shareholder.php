<?php

declare(strict_types=1);

namespace App\Models\Fund;

use App\Models\Users\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Shareholder extends Model
{
    use HasUuids;

    protected $table = 'statistics.shareholders_view';

    protected $primaryKey = 'uuid';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'total_payments' => 'float',
        'total_dividends' => 'float',
    ];

    protected $fillable = [
        'account_uuid',
        'total_payments',
        'total_dividends',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
