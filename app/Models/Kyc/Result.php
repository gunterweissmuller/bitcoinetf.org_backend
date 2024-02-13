<?php

declare(strict_types=1);

namespace App\Models\Kyc;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Result extends Model
{
    use HasUuids;

    protected $table = 'kyc.results';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'screen_uuid',
        'data',
    ];
}
