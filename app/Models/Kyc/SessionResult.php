<?php

declare(strict_types=1);

namespace App\Models\Kyc;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class SessionResult extends Model
{
    use HasUuids;

    protected $table = 'kyc.session_results';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'session_uuid',
        'screen_uuid',
        'data',
    ];
}
