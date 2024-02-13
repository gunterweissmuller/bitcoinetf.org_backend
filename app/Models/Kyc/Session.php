<?php

declare(strict_types=1);

namespace App\Models\Kyc;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Session extends Model
{
    use HasUuids;

    protected $table = 'kyc.sessions';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'form_uuid',
        'account_uuid',
        'current_screen_uuid',
        'status',
    ];
}
