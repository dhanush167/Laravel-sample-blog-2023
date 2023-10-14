<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
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
            'title' => [
                'required',
                Rule::unique('articles', 'title')->ignore($this->article),
                'max:255',
                'string',
            ],
            'slug' => [
                'required',
                Rule::unique('articles', 'slug')->ignore($this->article),
                'max:255',
                'string',
            ],
            'excerpt' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'status' => ['required', 'boolean'],
            'user_id' => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'tags' => ['array'],
        ];
    }
}
