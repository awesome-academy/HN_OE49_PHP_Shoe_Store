<?php

namespace App\Http\Requests\Brands;

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
            'name' => 'required|string|max:255|unique:brands,name,' . request()->id,
            'desc' => 'required|max:255|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('required', ['attr' => __('brand_name')]),
            'name.max' => __('max', ['attr' => __('brand_name'), 'value' => '255']),
            'name.string' => __('string', ['attr' => __('brand_name')]),
            'name.unique' => __('unique', ['attr' => __('brand_name')]),
            'desc.required' => __('required', ['attr' => __('desc')]),
            'desc.string' => __('string', ['attr' => __('desc')]),
            'desc.max' => __('max', ['attr' => __('desc'), 'value' => '255']),
        ];
    }
}
