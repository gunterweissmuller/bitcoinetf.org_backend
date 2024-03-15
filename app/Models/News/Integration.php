<?php

declare(strict_types=1);

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class Integration extends Model
{
    use HasUuids;

    protected $table = 'news.integrations';

    protected $primaryKey = 'uuid';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'public_key',
        'private_key',
        'link',
        'status',
    ];
}
