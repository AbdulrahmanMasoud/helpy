<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\FormRequest;

class RegisterRequest extends FormRequest
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
            'f_name'=> 'required|string|min:3|max:50',
            'l_name'=> 'required|string|min:3|max:50',
            'email'=> 'required|email|unique:users,email',
            'phone'=> 'required|size:11',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'password'=> 'required',
        ];
    }
    public function attributes()
    {
        return [
            'f_name' => 'اسم الاول',
        ];
    }
    public function messages()
    {
        return [
            'f_name.min' => 'الاسم يجب ان يكون اكثر من 4 حروف',
        ];
    }

}
