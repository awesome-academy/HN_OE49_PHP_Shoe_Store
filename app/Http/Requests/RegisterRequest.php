<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{
    public $validator = null;

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
            'name' => ['required', 'string', 'min:6', 'max:255'],
            'phone' => ['required', 'regex:/(0[3|5|7|8|9])+([0-9]{8})\b/', 'unique:users'],
            'email' => ['required', 'email', 'max:320', 'unique:users'],
            'address' => ['required', 'max:1000'],
            'password' => ['required', 'string', 'min:8', 'max:20'],
            'password-confirm' => ['required', 'string', 'min:8', 'max:20', 'same:password'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
