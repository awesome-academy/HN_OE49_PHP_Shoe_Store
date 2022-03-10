<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'content' => 'required',
            'rating' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => __('required', ['attr' => __('content')]),
            'rating.required' => __('required', ['attr' => __('rating')]),
        ];
    }
}
