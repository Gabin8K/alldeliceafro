<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_en' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($this->category)],
            'name_fr' => ['nullable', 'string', 'max:255', Rule::unique('categories')->ignore($this->category)],
            'name_de' => ['nullable', 'string', 'max:255', Rule::unique('categories')->ignore($this->category)],
            'images' => ['nullable', 'array']
        ];
    }
}
