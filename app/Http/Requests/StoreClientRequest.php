<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'nikename'=>'required',
            'realname'=>'required',
            'tel'=>'required',
            'pingtai'=>'required',
            'regtime'=>'required',
            'loginlasttime'=>'required',
            'daili'=>'required',
            'http'=>'required',
            'c_money'=>'required',
            't_money'=>'required',
        ];
    }

    //报错信息
    public function messages()
    {
        return [
            'nikename.required'=>'会员账号不可缺少',
            'realname.required'=>'姓名不可缺少',
            'tel.required'=>'手机号不可缺少',
            'pingtai.required'=>'平台不可缺少',
            'regtime.required'=>'注册时间不可缺少',
            'loginlasttime.required'=>'最后登录时间不可缺少',
            'daili.required'=>'代理不可缺少',
            'http.required'=>'网址不可缺少',
            'c_money.required'=>'存款金额不可缺少',
            't_money.required'=>'提款金额不可缺少',
        ];
    }
}
