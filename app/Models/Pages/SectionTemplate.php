<?php

declare(strict_types=1);

namespace App\Models\Pages;

use App\Models\Storage\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Section
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property array $data
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Section
 */
final class SectionTemplate extends Model
{
    protected $table = 'pages.section_templates';

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
        'name',
        'symbol',
        'data',
    ];

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'pages.section_template_file');
    }
}
