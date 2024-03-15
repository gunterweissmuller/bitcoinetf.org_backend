<?php

declare(strict_types=1);

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

final class GlobalModel extends Model
{
    protected $table = 'settings.globals';

    protected $primaryKey = 'symbol';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'symbol',
        'type',
        'value',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
