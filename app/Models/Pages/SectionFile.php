<?php

declare(strict_types=1);

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SectionFile
 * @property int $section_id
 * @property string $file_uuid
 * @property string $created_at
 *
 * @package App\Models\Page
 */
final class SectionFile extends Model
{
    protected $table = 'pages.section_file';

    public $timestamps = false;

    protected $hidden = [
        'pivot',
    ];

    protected $dates = [
        'created_at',
    ];

    protected $fillable = [
        'section_id',
        'file_uuid',
        'created_at',
    ];
}
