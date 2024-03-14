<?php

declare(strict_types=1);

namespace App\Models\Kyc;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Screen extends Model
{
    use HasUuids;

    protected $table = 'kyc.screens';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'form_uuid',
        'title',
        'subtitle',
        'sort',
    ];

    protected $casts = [
        'sort' => 'integer',
    ];
}
