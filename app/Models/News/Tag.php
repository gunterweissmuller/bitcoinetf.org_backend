<?php

declare(strict_types=1);

namespace App\Models\News;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Tag extends Model
{
    use HasUuids;

    protected $table = 'news.tags';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'section_uuid',
        'title',
    ];
}
