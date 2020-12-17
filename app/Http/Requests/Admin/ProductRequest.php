<?php

namespace App\Http\Requests\Admin;

use App\Local;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
        $roles =[
            'price' => 'required',
            'size' => 'required',
            'color_code' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'address_id' => 'required',
        ];
        if ($this->routeIs('admin.categories.store'))
        {
            $roles +=['main' => 'required|image|mimes:jpeg,jpg,png,svg,gif|max:20000'];
        }else
        {
            $roles +=['main' => 'nullable|image|mimes:jpeg,jpg,png,svg,gif|max:20000'];
        }

        foreach ($locales as $i=>$locale)
        {
            $roles+=[$locale.'.name'=>['required']];
            $roles+=[$locale.'.desc'=>['required']];
            $roles+=[$locale.'.color_name'=>['required']];
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
            'logo.image'=>'اللوجو يجب ان يكون بصيغة صورة',
            'parent.required'=>'حقل   مطلوب',
            'price.required'=>'حقل السعر مطلوب',
            'size.required'=>'حقل المقاس مطلوب',
            'color_code.required'=>'حقل كود اللون مطلوب',
            'status.required'=>'حقل الحالة مطلوب',
            'category_id.required'=>'حقل القسم مطلوب',
            'address_id.required'=>'حقل العنوان مطلوب',
        ];
        foreach ($locales as $i=>$locale)
        {
            $messages+=[$locale.'.name.required'=>'حقل الاسم '.$locale.' مطلوب'];
            $messages+=[$locale.'.desc.required'=>'حقل الوصف '.$locale.' مطلوب'];
            $messages+=[$locale.'.color_name.required'=>'حقل اسم اللون '.$locale.' مطلوب'];
        }
        return $messages;
    }
}
