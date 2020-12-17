<?php

namespace App\Http\Requests\Admin;

use App\Local;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddressRequest extends FormRequest
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
        $roles =[];

        foreach ($locales as $i=>$locale)
        {
            $roles+=[$locale.'.name'=>['required']];
            $roles+=[$locale.'.location'=>['required']];
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
        $messages = [];
        foreach ($locales as $i=>$locale)
        {
            $messages+=[$locale.'.name.required'=>'حقل الاسم '.$locale.' مطلوب'];
            $messages+=[$locale.'.location.required'=>'حقل العنوان '.$locale.' مطلوب'];
        }
        return $messages;
    }
}
