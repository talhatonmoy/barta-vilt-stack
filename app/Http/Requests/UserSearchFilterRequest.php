<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSearchFilterRequest extends FormRequest
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
        // dd($this);
        return [
            'city' => 'nullable|string|max:100', // Ensure city is required, a string, and max 100 characters
            'gender' => 'nullable|in:male,female,3rd_gender', // Only allow specific values for gender
            'primaryLang' => 'nullable|string|max:30', // Ensure primaryLang is required, a string, and max 30 characters
        ];
    }
}
