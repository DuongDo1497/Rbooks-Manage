<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollStoreRequest extends FormRequest
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
            'worksalary' => 'required',
            'effectdate' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'worksalary.required' => "Bạn chưa nhập mức lương công việc. Vui lòng nhập lại.",
            'effectdate.required' => "Bạn chưa nhập ngày bắt đầu hiệu lực. Vui lòng nhập lại.",
        ];
    }      
}
