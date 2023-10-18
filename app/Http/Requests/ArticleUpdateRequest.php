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
                'sometimes',
                'required',
                Rule::unique('articles', 'title')->ignore($this->article),
                'max:255',
                'min:3',
                'string',
            ],
            'slug' => [
                'sometimes',
                'required',
                Rule::unique('articles', 'slug')->ignore($this->article),
                'max:255',
                'min:3',
                'string',
            ],
            'excerpt' => ['required', 'max:255','min:3', 'string'],
            'description' => ['required', 'string','min:3',],
            'status' => ['required', 'boolean'],
            'user_id' => ['required', 'exists:users,id','integer'],
            'category_id' => ['required', 'exists:categories,id','integer'],
            'tags' => ['array','nullable'],
            'tags.*' => ['integer',Rule::exists('tags','id')],
        ];
    }
    public function filters():array {
        return [
            'title' => 'trim|sanitize',
            'slug' => 'trim|lowercase',
            'excerpt' => 'trim|sanitize',
            'description' => 'trim|sanitize',
            'status' => 'trim',
            'user_id' => 'trim|number',
            'category_id' => 'trim|number',
            'tags' => 'trim',
        ];
    }
}
