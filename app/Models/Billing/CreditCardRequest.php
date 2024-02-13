<?php

declare(strict_types=1);

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class CreditCardRequest extends Model
{
    use HasUuids;

    protected $table = 'billing.credit_card_requests';

    protected $primaryKey = 'uuid';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'account_uuid',
        'status',
    ];
}
