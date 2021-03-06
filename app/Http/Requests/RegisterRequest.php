<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*\d).+$/',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'terms_and_conditions' => 'accepted'
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password must contain at least one number',
        ];
    }
}
