<?php

namespace App\Http\Requests;

use App\Rules\locationCoordinates;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'secondary_title' => 'required|max:150|min:3',
            'content'=>'required',
            'start_date' =>'required|date|after:yesterday',
            'end_date'=>'required|date|after:start_date',
            'location'=>'nullable',
            // 'location_lat'=>new locationCoordinates,
            // 'location_lang'=>new locationCoordinates



        ];
    }
}
