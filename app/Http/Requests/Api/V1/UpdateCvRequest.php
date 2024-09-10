<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCvRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cv' => 'required|file|mimes:pdf'
        ];
    }
}
