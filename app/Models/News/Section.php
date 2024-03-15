<?php

declare(strict_types=1);

namespace App\Models\News;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Section extends Model
{
    use HasUuids;

    protected $table = 'news.sections';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}
