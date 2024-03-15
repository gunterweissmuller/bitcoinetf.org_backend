<?php

declare(strict_types=1);

namespace App\Models\Kyc;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class SessionFile extends Model
{
    use HasUuids;

    protected $table = 'kyc.session_files';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'session_uuid',
        'file_uuid',
    ];
}
