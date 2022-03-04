<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:6', 'max:255'],
            'email' => ['required', 'email', 'max:320', 'unique:users,email,' . request()->id],
            'phone' => ['required', 'regex:/(0[3|5|7|8|9])+([0-9]{8})\b/', 'unique:users,phone,' . request()->id],
            'address' => ['required', 'max:1000'],
            'avatar' => ['image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('required', ['attr' => __('name')]),
            'name.string' => __('string', ['attr' => __('name')]),
            'name.min' => __('min', ['attr' => __('name'), 'value' => '6']),
            'name.max' => __('max', ['attr' => __('name'), 'value' => '255']),
            'email.required' => __('required', ['attr' => __('email')]),
            'email.email' => __('email_val'),
            'email.max' => __('max', ['attr' => __('email'), 'value' => '320']),
            'email.unique' => __('unique', ['attr' => __('email')]),
            'phone.required' => __('required', ['attr' => __('phone')]),
            'phone.regex' => __('regex', ['attr' => __('phone')]),
            'phone.unique' => __('unique', ['attr' => __('phone')]),
            'address.required' => __('required', ['attr' => __('address')]),
            'address.max' => __('max', ['attr' => __('address'), 'value' => '1000']),
            'avatar.image' => __('image', ['attr' => __('avatar')]),
            'avatar.*.mimes' => __('mimes', ['attr' => __('avatar')]),
            'avatar.max' => __('max_avt'),
        ];
    }
}
