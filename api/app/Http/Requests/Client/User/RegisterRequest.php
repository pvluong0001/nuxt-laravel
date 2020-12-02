<?php

namespace App\Http\Requests\Client\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'email' => [
                'email',
                'required',
                Rule::unique('users', 'email')
            ],
            'password' => 'required|max:128',
            'name' => 'required|max:128'
        ];
    }
}
