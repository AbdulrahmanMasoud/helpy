<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\FormRequest;

class ReportRequest extends FormRequest
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
            'marker_id'=>'exists:reports,marker_id',
            'title'=>'required|min:10|string',
            'description'=>'required|min:30',
            'proof'=>'nullable|image|mimes:jpg,bmp,png,jpge',
        ];
    }
}
