<?php

declare(strict_types=1);

namespace App\Models\News;

use App\Models\Storage\File;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Article extends Model
{
    use HasUuids;

    protected $table = 'news.articles';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'section_uuid',
        'title',
        'description',
        'content',
        'slug',
        'reading_time',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_at',
        'updated_at',
    ];

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'news.article_files');
    }
}
