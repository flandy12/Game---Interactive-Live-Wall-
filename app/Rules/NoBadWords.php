<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoBadWords implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $badWords = config('badwords');

        foreach ($badWords as $word) {
            if (stripos($value, $word) !== false) {
                $fail("Kolom :attribute mengandung kata yang tidak pantas.");
                return;
            }
        }
    }
}
