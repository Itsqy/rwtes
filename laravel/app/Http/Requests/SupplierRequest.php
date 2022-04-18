<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'suppliername' => 'required|unique:supplier,suppliername',
        ];
    }

    public function messages()
    {
        return [
            'suppliername.required' => 'Name is required',
            'suppliername.unique' => 'Supplier is already created',
        ];
    }
}
