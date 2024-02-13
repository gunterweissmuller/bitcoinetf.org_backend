<?php

declare(strict_types=1);

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 * @property string $uuid
 * @property string $path
 * @property string $real_path
 * @property string $type
 * @property string $extension
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Storage
 */
final class File extends Model
{
    use HasUuids;

    protected $table = 'storage.files';

    protected $primaryKey = 'uuid';

    protected $hidden = [
        'pivot',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'path',
        'real_path',
        'type',
        'extension',
        'status',
    ];
}
