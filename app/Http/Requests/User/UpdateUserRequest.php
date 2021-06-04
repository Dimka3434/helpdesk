<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'sometimes|nullable|string|email',
            'type' => 'sometimes|nullable|numeric',
            'name' => 'sometimes|nullable|string',
            'new_password' => 'sometimes|nullable|string',
        ];
    }
}
