<?php

declare(strict_types=1);

namespace App\Models\News;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class ArticleFile extends Model
{
    use HasUuids;

    protected $table = 'news.article_files';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'article_uuid',
        'file_uuid',
        'type',
    ];
}
