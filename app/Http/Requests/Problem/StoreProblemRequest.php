<?php

namespace App\Http\Requests\Problem;

use Illuminate\Foundation\Http\FormRequest;

class StoreProblemRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'subcategory_id' => 'required|exists:subcategories,id',
            'place' => 'required|string|min:5',
            'description' => 'nullable|string|min:10',
        ];
    }

    public function attributes()
    {
        return [
            'subcategory_id' => 'категория',
            'place' => 'местонахождение',
            'description' => 'Описание проблемы',
        ];
    }
}
