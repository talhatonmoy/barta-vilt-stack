<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDetailUpdateRequest extends FormRequest
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
            'mobile' => 'nullable|string|max:30', // Assuming mobile can be up to 15 characters
            'website' => 'nullable|url', // Must be a valid URL
            'facebook' => 'nullable|url', // Must be a valid URL
            'whatsapp' => 'nullable|string|max:30', // Assuming a max length for WhatsApp number
            'linkedin' => 'nullable|url', // Must be a valid URL
            'gender' => 'nullable|string', // Only allows specified values
            'date_of_birth' => 'nullable|date|before:today', // Must be a valid date and in the past
            'nick_name' => 'nullable|string|max:50', // Max length for nickname
            'primary_lang' => 'nullable|string|max:30', // Assuming language code length (e.g., "en", "fr")
            'secondary_lang' => 'nullable|string|max:30', // Assuming language code length
            'favorite_quote' => 'nullable|string|max:255', // Max length for quotes
            'current_city' => 'nullable|string|max:100', // Max length for city name
        ];
    }
}
