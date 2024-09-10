<?php

namespace App\Http\Requests\Admin\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'numeric'],
            'name_en' => ['required', 'string', 'max:255', Rule::unique('articles')->ignore($this->article)],
            'name_fr' => ['nullable', 'string', 'max:255', Rule::unique('articles')->ignore($this->article)],
            'name_de' => ['nullable', 'string', 'max:255', Rule::unique('articles')->ignore($this->article)],
            'description_en' => ['nullable', 'string', 'max:765'],
            'description_fr' => ['nullable', 'string', 'max:765'],
            'description_de' => ['nullable', 'string', 'max:765'],
            'weight' => ['required', 'integer'],
            'images' => ['nullable', 'array']
        ];
    }
}
