<?php

declare(strict_types=1);

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Page
 */
final class Page extends Model
{
    protected $table = 'pages.pages';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];
}
