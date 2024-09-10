<?php

namespace App\Http\Requests\Admin\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateShopRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'uuid'],
            'name' => ['required', 'string', 'max:255', Rule::unique('shops')->ignore($this->shop)],
            'description_en' => ['nullable', 'string', 'max:765'],
            'description_fr' => ['nullable', 'string', 'max:765'],
            'description_de' => ['nullable', 'string', 'max:765'],
            'images' => ['nullable', 'array']
        ];
    }
}
