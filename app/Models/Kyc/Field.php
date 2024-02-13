<?php

declare(strict_types=1);

namespace App\Models\Kyc;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Field extends Model
{
    use HasUuids;

    protected $table = 'kyc.fields';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'screen_uuid',
        'name',
        'label',
        'type',
        'required',
        'enums',
        'sort',
    ];

    protected $casts = [
        'sort' => 'integer',
    ];
}
