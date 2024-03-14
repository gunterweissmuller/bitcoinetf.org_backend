<?php

declare(strict_types=1);

namespace App\Models\Pages;

use App\Models\Storage\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Section
 * @property int $id
 * @property int $pageId
 * @property int $language_id
 * @property string $name
 * @property string $status
 * @property int $number
 * @property array $data
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Section
 */
final class Section extends Model
{
    protected $table = 'pages.sections';

    protected $hidden = [
        'pivot',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'page_id',
        'language_id',
        'name',
        'status',
        'number',
        'data',
    ];

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'pages.section_file');
    }
}
