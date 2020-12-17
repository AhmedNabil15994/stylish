<?php

namespace App\Http\Requests\Admin;

use App\Local;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TipRequest extends FormRequest
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
        $locales = Local::all()->pluck('code');
        if ($this->routeIs('admin.articles.store'))
        {
            $roles =['photo' => 'required|image|mimes:jpeg,jpg,png,svg,gif|max:20000'];
        }else
        {
            $roles =['photo' => 'nullable|image|mimes:jpeg,jpg,png,svg,gif|max:20000'];
        }

        foreach ($locales as $i=>$locale)
        {
            $roles+=[$locale.'.title'=>['required']];
            $roles+=[$locale.'.desc'=>['required']];
        }
        return $roles;
    }

    protected function failedValidation(Validator $validator)
    {
        $result = ['status' => 'error' ,'data' => implode("<br>" , $validator->errors()->all())];

        throw new HttpResponseException(response()->json($result , 200));
    }


    public function messages()
    {
        $locales = Local::all()->pluck('code');
        $messages = [
            'photo.required'=>'حقل الصورة مطلوب',
            'photo.image'=>'اللوجو يجب ان يكون بصيغة صورة',
        ];
        foreach ($locales as $i=>$locale)
        {
            $messages+=[$locale.'.title.required'=>'حقل العنوان '.$locale.' مطلوب'];
            $messages+=[$locale.'.desc.required'=>'حقل الوصف '.$locale.' مطلوب'];
        }
        return $messages;
    }
}
