<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'f_name'=> 'required',
            'l_name'=> 'required',
            'email'=> 'required|email|'.Rule::unique('users')->ignore(Auth::id()),
            'phone'=> 'required|size:11',
            'avatar' => 'nullable|file|mimes:jpg,png,jpge,jpeg',
            'password'=> 'required',
            'country'=> 'required',
            'city'=> 'required',
            'address'=> 'required',
        ];
    }
}
