<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
        $isEmail = filter_var($this->login, FILTER_VALIDATE_EMAIL);
        return [
            'login' => ['required','string', Rule::when($isEmail, ['email:rfc,dns'])],
            'password' => 'required|string|min:8|max:64',
        ];
    }
}
