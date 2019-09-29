<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffMemberRequest extends FormRequest
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
        $user = User::find((int) request()->segment(2)); 
        return  [
            'job_id' => ['required'],
            'role_id' => ['required'],
            'country_id' => ['required'],
            'city_id' => ['required'],
            'first_name' => ['required', 'string', 'max:255', 'min:3'],
            'last_name' => ['required', 'string', 'max:255', 'min:3'],
            'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users,phone,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'gender' => ['required'],
            'image_name' => 'image|mimes:jpeg,bmp,jpg,png|max:2048',
        ];
    }
}
