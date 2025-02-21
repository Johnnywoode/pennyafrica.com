<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class USSDRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sessionID' => 'required|string',
            'userID' => 'required|string',
            'newSession' => 'required|string',
            'msisdn' => 'required|string|min:10|max:15',
            'userData' => 'required|nullable|string',
            'network' => 'required|string',
        ];
    }

    /**
     * Sanitize and return validated input.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'userData' => trim($this->input('userData')),
        ]);
    }
}
