<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

final class DateAgeValidator implements Rule
{

    public function passes($attribute, $value)
    {
        $value = Carbon::parse($value);
        $dif = $value->diffInYears(Carbon::now(), false);

        if ($dif < 0 || $dif > 100) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Enter a valid :attribute.';
    }
}
