<?php

declare(strict_types=1);

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $is_editable
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Language
 */
final class Language extends Model
{
    protected $table = 'pages.languages';

    protected $casts = [
        'is_editable' => 'bool',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'slug',
        'is_editable',
    ];
}
