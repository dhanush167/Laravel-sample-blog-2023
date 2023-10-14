<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255', 'unique:articles,id'],
            'excerpt' => ['required', 'string'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'tags' => ['nullable', 'array']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
