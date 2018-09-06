<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoginRequest extends FormRequest
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
            'mg_name'=>'required|max:15',
            'password'=>'required',
            'code'=>'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'mg_name.required'=>'管理员名称必须添写!',
            'mg_name.max'=>'管理员名称不得大于15个字符!',
            'password.required'=>'密码必须填写!',
            'code.required'=>'验证码必须填写!',
            'code.captcha'=>'验证码不对!',
        ];
    }
}
