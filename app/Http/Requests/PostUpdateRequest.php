<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'new_images_to_add' => ['nullable', 'array'],
            'new_images_to_add.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validate each image
            'remove_image_ids_from_post' => ['array']
        ];
    }
}
