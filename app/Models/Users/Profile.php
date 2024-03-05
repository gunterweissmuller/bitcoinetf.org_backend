<?php

declare(strict_types=1);

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 * @property string $accountUuid
 * @property string $fullName
 * @property string $dateOfBirth
 * @property string $taxResidence
 * @property string $address
 * @property string $city
 * @property string $postalCode
 * @property string $state
 * @property string $country
 * @property string $phoneNumber
 * @property string $phoneNumberCode
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models\Users
 */
final class Profile extends Model
{
    use HasUuids;

    protected $table = 'users.profiles';

    protected $primaryKey = 'account_uuid';

    protected $fillable = [
        'account_uuid',
        'full_name',
        'date_of_birth',
        'tax_residence',
        'address',
        'city',
        'postal_code',
        'state',
        'country',
        'phone_number',
        'phone_number_code',
    ];
}
