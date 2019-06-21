<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCedisRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address'         => ['required',],
            'global_name'     => ['required',],
            'latitude'        => ['required',],
            'longitude'       => ['required',],
            'image_01'        => ['required',]
        ];
    }

    public function messages()
    {
        return [
            'address.required'         => trans('admin::cedis.validation.address'),
            'latitude.required'        => trans('admin::cedis.validation.latitude'),
            'longitude.required'       => trans('admin::cedis.validation.longitude'),
            'image_01.required'        => trans('admin::cedis.validation.image_01'),
            'global_name.required'     => trans('admin::cedis.validation.global_name'),
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
