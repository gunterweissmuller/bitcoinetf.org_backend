<?php

declare(strict_types=1);

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Facebook
 * @property string $uuid
 * @property string $account_uuid
 * @property string $facebook_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Users
 */
final class Facebook extends Model
{
    use HasUuids;

    protected $table = 'users.facebooks';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'facebook_id',
        'status',
    ];
}
