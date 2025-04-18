<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'expiration_type' => ['required', 'boolean'],
            'deadline' => ['required', 'date'],
            'comment' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'image', 'max:10240']
        ];
    }
}
