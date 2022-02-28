<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:320'],
            'password' => ['required', 'string', 'min:8', 'max:20'],
        ];
    }
    
    public function messages()
    {
        return [
            'email.required' => __('required', ['attr' => __('email')]),
            'email.email' => __('email_val'),
            'email.max' => __('max', ['attr' => __('email'), 'value' => '320']),
            'password.required' => __('required', ['attr' => __('password')]),
            'password.string' => __('string', ['attr' => __('password')]),
            'password.min' => __('min', ['attr' => __('password'), 'value' => '8']),
            'password.max' => __('max', ['attr' => __('password'), 'value' => '20']),
        ];
    }
}
