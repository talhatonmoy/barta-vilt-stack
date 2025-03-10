<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'post_body' => ['required', 'max:2000'],
            'post_images' => ['nullable', 'array'],
            'post_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validate each image
        ];
    }
}
