<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManagerRequest extends FormRequest
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
            'mg_name'=>'required',  //|unique:manager
            'password'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'mg_name.required'=>'用户名必须填写!',
            'mg_name.unique'=>'用户名重复添加!',
            'password.required'=>'密码必须填写!',
        ];
    }
}
