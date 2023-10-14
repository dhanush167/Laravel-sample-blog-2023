<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('categories', 'name')->ignore($this->category),
                'max:255',
                'string',
            ],
            'description' => ['nullable', 'max:255', 'string'],
            'slug' => [
                'required',
                Rule::unique('categories', 'slug')->ignore($this->category),
                'max:255',
                'string',
            ],
        ];
    }
}
