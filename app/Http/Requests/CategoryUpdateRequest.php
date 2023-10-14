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
                'sometimes',
                'required',
                Rule::unique('categories', 'name')->ignore($this->category),
                'max:255',
                'min:3',
                'string',
            ],
            'description' => ['nullable', 'string'],
            'slug' => [
                'sometimes',
                'required',
                Rule::unique('categories', 'slug')->ignore($this->category),
                'max:255',
                'min:3',
                'string',
            ],
        ];
    }
}
