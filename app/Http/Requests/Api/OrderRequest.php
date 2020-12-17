<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
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
        $roles =  [
            'size'=>'required',
            'color_code'=>'required',
            'color_name'=>'required',
            'test_date'=>'required',
            'type'=>'required',
        ];
        if ($this->request->get('type') == 1)
        {
            $roles = array_merge($roles,[
                'shoulder_width'=>'required',
                'chest_circumference'=>'required',
                'middle_body'=>'required',
                'buttocks'=>'required',
                'arm_length'=>'required',
                'arm_circumference'=>'required',
                'wristband'=>'required',
                'overall_height'=>'required',
                'one_shoulder'=>'required',
                'back_length'=>'required',
                'from_shoulder_to_chest'=>'required',
                'from_shoulder_middle'=>'required',
                'pocket_length'=>'required',
            ]);
        }
        return $roles;
    }

    protected function failedValidation(Validator $validator)
    {
        $result = ['status' => 'error' ,'data' => $validator->errors()->all()];

        throw new HttpResponseException(response()->json($result , 400));
    }
}
