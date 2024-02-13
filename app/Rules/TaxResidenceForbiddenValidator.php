<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

final class TaxResidenceForbiddenValidator implements Rule
{

    public function passes($attribute, $value)
    {
        $forbiddens = ['united-states', 'north-korea', 'iran'];

        if (in_array($value, $forbiddens)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Your tax residency is not supported.';
    }
}
