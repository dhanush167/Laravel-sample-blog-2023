<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TagUpdateRequest extends FormRequest
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
                Rule::unique('tags', 'name')->ignore($this->tag),
                'max:255',
                'min:3',
                'string',
            ],
            'slug' => [
                'sometimes',
                'required',
                Rule::unique('tags', 'slug')->ignore($this->tag),
                'max:255',
                'min:3',
                'string',
            ],
        ];
    }
}
