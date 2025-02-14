<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class ValidateLogin implements ValidationRule
{
    protected $data;
    protected $user;

    /**
     * Constructor to receive the user instance.
     */
    public function __construct(array  $data)
    {
        $this->data = $data;

        $this->user = User::where('phone', preg_replace('/\D/', '', ($data['country_code'] ? $data['country_code'] . $data['phone'] : $data['phone'])))->first();
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // dd($this->data, $this->user);
        if (!$this->user || !Hash::check($this->data['password'], $this->user->details->password)) {
            $fail(__('validation.custom.phone.invalid_login_credentials'));
        }
    }
}
