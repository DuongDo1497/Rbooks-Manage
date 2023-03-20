<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceStoreRequest extends FormRequest
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
            'salaryinsurance' => 'required',
            'effectdate' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'salaryinsurance.required' => "Bạn chưa nhập mức lương đóng BHXH. Vui lòng nhập lại.",
            'effectdate.required' => "Bạn chưa nhập ngày bắt đầu hiệu lực. Vui lòng nhập lại.",
        ];
    }    
}
