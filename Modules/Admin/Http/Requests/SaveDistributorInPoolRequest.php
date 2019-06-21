<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class SaveDistributorInPoolRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory) {
        $validationFactory->extend(
            'admirable_customer',
            function ($attribute, $value, $parameters) {
                return !$this->isAdmirableCustomer($value);
            },
            trans('admin::distributorsPool.validation.client_adm')
        );

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $updated = $this->get('update');
        $rules = [
            'code'  => ['required','unique:shop_distributors_pool,distributor_code,NULL,id,country_id,'.$this->get('country'),'admirable_customer'],
            'name'  => ['required','max:200'],
            'email' => ['required','email', 'max:200'],
        ];

        if (!empty($updated) && $this->get('update') == 1) {
            $rules['code'] = ['required','admirable_customer'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'code.required'  => trans('admin::distributorsPool.validation.code_req'),
            'code.unique'    => trans('admin::distributorsPool.validation.code_uniq'),
            'name.required'  => trans('admin::distributorsPool.validation.name'),
            'email.required' => trans('admin::distributorsPool.validation.email_req'),
            'email.email'    => trans('admin::distributorsPool.validation.email_ema'),
            'email.max'      => trans('admin::distributorsPool.validation.email_limit'),
            'name.max'       => trans('admin::distributorsPool.validation.name_limit'),
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

    private function isAdmirableCustomer($param) {
        return (!empty($param) && strlen($param) > 1 && strtoupper($param[0]) == 'C');
    }
}
