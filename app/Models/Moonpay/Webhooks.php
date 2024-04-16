<?php

namespace App\Models\Moonpay;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Webhooks extends Model
{
    use HasUuids;

    protected $table = 'apollopayment.moonpay_webhooks';

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
