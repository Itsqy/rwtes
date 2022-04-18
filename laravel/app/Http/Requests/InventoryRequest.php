<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
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
            'inventoryname' => 'required|unique:inventory,inventoryname',
        ];
    }

    public function messages()
    {
        return [
            'inventoryname.required' => 'Name is required',
            'inventoryname.unique' => 'Inventory is already created',
        ];
    }
}
