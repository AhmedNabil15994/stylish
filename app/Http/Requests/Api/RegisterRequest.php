<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $roles = [
            'f_name' => 'required',
            'l_name' => 'required',
//            'phone' => 'required|unique:users,phone',
//            'email' => 'required|email|unique:users,email',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,svg,gif|max:20000',
            'device_token' => 'required',
        ];

        if ($this->routeIs('api.account.update'))
        {
            $roles +=['phone' => "required|unique:users,phone,{$this->user()->id}"];
            $roles +=['email' => "required|unique:users,email,{$this->user()->id}"];
        }

        if ($this->routeIs('api.register'))
        {
            $roles +=['phone' => "required|unique:users,phone"];
            $roles +=['email' => "required|unique:users,email"];
            $roles +=['password' => 'required|min:6'];
        }
        return  $roles;
    }

    protected function failedValidation(Validator $validator)
    {
        $result = ['status' => 'error' ,'data' => $validator->errors()->all()];

        throw new HttpResponseException(response()->json($result , 400));
    }

    public function messages()
    {
        return [
            'f_name.required'=>'حقل الاسم الاول مطلوب',
            'l_name.required'=>'حقل الاسم الاخير مطلوب',
            'phone.required'=>'حقل الهاتف مطلوب',
            'phone.unique'=>'هذا الهاتف مستخدم من قبل',
            'email.required'=>'حقل البريد الالكترونى مطلوب',
            'email.unique'=>'هذا البريد الالكترونى مستخدم من قبل',
            'password.required'=>'حقل كلمة المرور مطلوب',
            'photo.image'=>'الصورة يجب ان تكون بصيغة صحيحة',
        ];
    }
}
