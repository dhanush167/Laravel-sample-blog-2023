<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
                'unique:categories,name',
                'max:255',
                'string',
            ],
            'description' => ['nullable', 'max:255', 'string'],
            'slug' => [
                'required',
                'unique:categories,slug',
                'max:255',
                'string',
            ],
        ];
    }
}
