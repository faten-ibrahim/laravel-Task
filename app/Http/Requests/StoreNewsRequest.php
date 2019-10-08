<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'main_title' => 'required|max:150|min:3',
            'secondary_title' => 'nullable|max:150|min:3',
            'type' => 'required',
            'author' => 'required',
            'content'=>'required',
            // 'files' => 'nullable',
            'files.*' => 'image|mimes:jpg,png,xls,pdf|max:1024',
        ];
    }
}
