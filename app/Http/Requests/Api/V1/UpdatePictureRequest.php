<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePictureRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'picture' => 'required|image|mimes:jpeg,png,jpg'
        ];
    }
}
