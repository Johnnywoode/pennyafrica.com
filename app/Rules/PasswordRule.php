<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordRule implements ValidationRule
{
    /**
     * Validate password strength:
     * - At least 8 characters
     * - At least one uppercase letter
     * - At least one lowercase letter
     * - At least one number
     * - At least one special character
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $value)) {
            $fail("The {$attribute} must be at least 8 characters long, include one uppercase letter, one lowercase letter, one number, and one special character.");
        }
    }
}
