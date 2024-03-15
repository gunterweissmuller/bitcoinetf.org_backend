<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

final class FullAgeValidator implements Rule
{

    public function passes($attribute, $value)
    {
        $value = Carbon::parse($value);

        if ($value->diffInYears(Carbon::now(), false) > 18) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'You must be over 18 years old.';
    }
}
