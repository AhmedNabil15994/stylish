<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileRequest extends FormRequest
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
        $roles =[
            'email'=>"required|unique:users,email,{$this->user('admin')->id}",
            'username'=>"required|unique:users,username,{$this->user('admin')->id}",
            'name'=>'required',
            'phone'=>'required',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,svg,gif|max:20000',
        ] ;
        return $roles;
    }

    protected function failedValidation(Validator $validator)
    {
        $result = ['status' => 'error' ,'data' => implode("<br>" , $validator->errors()->all())];

        throw new HttpResponseException(response()->json($result , 200));
    }

     public function messages()
    {
        $messages = [
            'email.required'=>'حقل البريد الالكترونى مطلوب',
            'username.required'=>'حقل اسم المستخدم مطلوب',
            'name.required'=>'حقل الاسم مطلوب',
            'phone.required'=>'حقل الهاتف مطلوب',
            'gender.required'=>'حقل النوع مطلوب',
            'photo.image'=>'الصورة يجب ان تكون بصيغة صحيحة',
        ];

        return $messages;
    }
}
