<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class ValidatePassword implements ValidationRule
{
    protected $user;

    /**
     * Constructor to receive the user instance.
     */
    public function __construct($phone)
    {
        $this->user = User::where('phone', $phone)->first();
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->user || !Hash::check($value, $this->user->password)) {
            $fail(__('validation.custom.phone.validate_password'));
        }
    }
}
