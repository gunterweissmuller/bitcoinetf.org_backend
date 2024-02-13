<?php

declare(strict_types=1);

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SectionTemplateFile
 * @property int $section_template_id
 * @property string $file_uuid
 * @property string $created_at
 *
 * @package App\Models\Page
 */
final class SectionTemplateFile extends Model
{
    protected $table = 'pages.section_template_file';

    public $timestamps = false;

    protected $hidden = [
        'pivot',
    ];

    protected $dates = [
        'created_at',
    ];

    protected $fillable = [
        'section_template_id',
        'file_uuid',
        'created_at',
    ];
}
