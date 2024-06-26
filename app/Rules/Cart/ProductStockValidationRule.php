<?php

namespace App\Rules\Cart;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductStockValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value - 1 < 0) {
            $fail('This product is out of stock!');
        }
    }
}
