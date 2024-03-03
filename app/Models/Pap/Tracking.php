<?php

namespace App\Models\Pap;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasUuids;

    protected $table = 'pap.tracking';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'event_type',
        'pap_id',
        'utm_label',
        'real_amount',
        'amount_type',
    ];
}
