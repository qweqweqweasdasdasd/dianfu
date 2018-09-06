<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFenpeiRequest extends FormRequest
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
            'title'=>'required|between:2,10', //unique:fenpei
            'sum'=>'required|numeric'
        ];
    }

    //报错信息
    public function messages()
    {
        return [
            'title.required'=>'标题是必须要填写的!',
            'title.between'=>'标题大于2小于10个字符!',
            'sum.required'=>'回访数量必须填写!',
            'sum.numeric'=>'回访数量必须是数字!',
            //'title.unique'=>'标题内容不可重复的哦',
        ];
    }
}
