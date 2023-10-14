<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => [
                'required',
                'unique:articles,title',
                'max:255',
                'string',
            ],
            'slug' => ['required', 'unique:articles,slug', 'max:255', 'string'],
            'excerpt' => ['required', 'max:255', 'string'],
            'description' => ['required', 'string'],
            'status' => ['in:on'],
            'user_id' => ['required', 'exists:users,id'],
            'category_id' => ['required','integer','exists:categories,id'],
            'tags' => ['array','nullable'],
            'tags.*' => ['integer',Rule::exists('tags','id')],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
