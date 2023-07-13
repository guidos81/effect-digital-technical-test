<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Base64Encoded implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $array = explode(',', $value);

        if (count($array) > 2)
            $fail('The :attribute must be a valid Base64 encoded string.');

        $value = count($array) > 1 ? $array[1] : $array[0];

        if (!base64_decode($value, true)) {
            $fail('The :attribute must be a valid Base64 encoded string.');
        }
    }
}
