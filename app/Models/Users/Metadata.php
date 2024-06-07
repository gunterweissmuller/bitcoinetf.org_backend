<?php

declare(strict_types=1);

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Metadata
 * @property string $uuid
 * @property string $account_uuid
 * @property string $ipv4_address
 * @property string $user_agent
 * @property string $location
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Users
 */
final class Metadata extends Model
{
    use HasUuids;

    protected $table = 'users.metadata';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'account_uuid',
        'ipv4_address',
        'user_agent',
        'location',
    ];
}
