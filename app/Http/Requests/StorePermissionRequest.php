<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
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
            'p_name'=>'required',
            'ps_c'=>'required',
            'ps_a'=>'required',
            'ps_route'=>'required',
        ];
    }

    //错误信息打印
    public function messages()
    {
        return [
            'p_name.required'=>'权限的名称必须填写!',
            'ps_c.required'=>'控制器名称必须填写!',
            'ps_a.required'=>'方法名称必须填写!',
            'ps_route.required'=>'路由名称必须填写!',
        ];
    }
}
