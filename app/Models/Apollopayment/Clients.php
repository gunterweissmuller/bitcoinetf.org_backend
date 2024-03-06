<?php

namespace App\Models\Apollopayment;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasUuids;

    protected $table = 'apollopayment.clients';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'client_id',
        'webhook_url',
        'ethereum_addr',
        'tron_addr',
        'polygon_addr',
    ];
}
