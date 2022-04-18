<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'roomname' => 'required|unique:room,roomname',
        ];
    }

    public function messages()
    {
        return [
            'roomname.required' => 'Name is required',
            'roomname.unique' => 'Room is already created',
        ];
    }
}
