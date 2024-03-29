<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitorRequest extends FormRequest
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
        return  [
            'country_id' => ['required'],
            'city_id' => ['required'],
            'first_name' => ['required', 'string', 'max:255', 'min:3'],
            'last_name' => ['required', 'string', 'max:255', 'min:3'],
            'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users,id,'.$this->id,
            'email' => 'required|string|email|max:255|unique:users,id,' . $this->id,
            'gender' => ['required'],
            'image_name' => 'nullable|image|mimes:jpeg,bmp,jpg,png|max:2048',
        ];
    }
}
