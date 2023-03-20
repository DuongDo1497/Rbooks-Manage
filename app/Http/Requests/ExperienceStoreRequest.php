<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceStoreRequest extends FormRequest
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
            'companyname' => 'required',
            'fromdate' => 'required',
            'todate' => 'required',            
        ];
    }

    public function messages()
    {
        return [
            'companyname.required' => "Bạn chưa nhập tên công ty. Vui lòng nhập lại.",
            'fromdate.required' => "Bạn chưa nhập ngày bắt đầu. Vui lòng nhập lại.",
            'todate.required' => "Bạn chưa nhập ngày kết thúc. Vui lòng nhập lại.",
        ];
    }  
}
