<?php

declare(strict_types=1);

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 * @property string $uuid
 * @property string $username
 * @property string $type
 * @property string $status
 * @property string $password
 * @property float $personal_bonus
 * @property float $increased_minimum_apy
 * @property string $tron_wallet
 * @property bool $fast_reg
 * @property bool $fast_payment
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Users
 */
final class Account extends Model
{
    use HasUuids;

    protected $table = 'users.accounts';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'username',
        'type',
        'status',
        'password',
        'personal_bonus',
        'increased_minimum_apy',
        'tron_wallet',
        'fast_reg',
        'fast_payment',
    ];

    public $casts = [
        'personal_bonus' => 'float',
        'increased_minimum_apy' => 'float',
        'fast_reg' => 'boolean',
        'fast_payment' => 'boolean',
    ];
}
