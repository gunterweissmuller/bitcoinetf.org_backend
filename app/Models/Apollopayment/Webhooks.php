<?php

namespace App\Models\Apollopayment;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Webhooks extends Model
{
    use HasUuids;

    protected $table = 'apollopayment.webhooks';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'client_id',
        'webhook_id',
        'address_id',
        'amount',
        'currency',
        'network',
        'tx',
        'type',
        'payload',
    ];
}
