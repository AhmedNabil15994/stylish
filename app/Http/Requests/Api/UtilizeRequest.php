<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UtilizeRequest extends FormRequest
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
            'name'=>'required',
            'price'=>'required',
            'size'=>'required',
            'color_code'=>'required',
            'color_name'=>'required',
            'status'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'lat'=>'required',
            'lng'=>'required',
            'category_id'=>'required',
            'main_photo' => 'required|image|mimes:jpeg,jpg,png,svg,gif|max:20000',
            'sub_photos.*' => 'image|mimes:jpeg,jpg,png,svg,gif|max:20000',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $result = ['status' => 'error' ,'data' => $validator->errors()->all()];

        throw new HttpResponseException(response()->json($result , 400));
    }

    public function messages()
    {
        return [
            'name.required'=>'حقل الاسم مطلوب',
            'price.required'=>'حقل السعر مطلوب',
            'size.required'=>'حقل المقاس مطلوب',
            'color_code.required'=>'حقل كود اللون مطلوب',
            'color_name.required'=>'حقل اسم اللون مطلوب',
            'status.required'=>'حقل حالة الفستان مطلوب',
            'phone.required'=>'حقل الهاتف مطلوب',
            'address.required'=>'حقل العنوان مطلوب',
            'lat.required'=>'حقل خطوط الطول مطلوب',
            'lng.required'=>'حقل دوائر العرض مطلوب',
            'category_id.required'=>'حقل القسم مطلوب',
            'main_photo.required'=>'حقل الصورة الرئيسية مطلوب',
        ];
    }
}
