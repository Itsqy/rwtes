<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'employeename' => 'required|unique:employee,employeename',
        ];
    }

    public function messages()
    {
        return [
            'employeename.required' => 'Name is required',
            'employeename.unique' => 'Employee is already created',
        ];
    }
}
