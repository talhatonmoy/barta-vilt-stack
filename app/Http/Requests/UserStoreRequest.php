<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'first_name' => ['required', 'max:100'],
            'last_name'  => ['required', 'max:50'],
            'user_name'  => ['required', 'unique:users', 'lowercase'],
            'email'      => ['required', 'email:rfc', 'unique:users'],
            'password'      => ['required'],
            // 'password'      => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ];
    }
}
