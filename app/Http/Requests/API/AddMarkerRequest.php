<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\FormRequest;

class AddMarkerRequest extends FormRequest
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
        'title'=>'required|string|min:10',
        'gender'=>'required',
        'mental_state'=>'required',
        'adult'=>'required',
        'description'=>'nullable|min:50',
        'latitude'=>'required|numeric|min:4',
        'longitude'=>'required|numeric|min:4',
        'proof'=>'nullable|file|mimes:jpg,bmp,png,jpge',
        'status'=>'boolean'
        ];
    }
}
