<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequest extends FormRequest
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
                'unique:articles,title',
                'max:255',
                'min:3',
                'string',
            ],
            'slug' => ['required', 'unique:articles,slug', 'max:255', 'string','min:3'],
            'excerpt' => ['required', 'max:255', 'string','min:3'],
            'description' => ['required', 'string','min:3'],
            'status' => ['required', 'boolean'],
            'user_id' => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id','integer'],
            'tags' => ['array','nullable'],
            'tags.*' => ['integer',Rule::exists('tags','id')],
        ];
    }
}
