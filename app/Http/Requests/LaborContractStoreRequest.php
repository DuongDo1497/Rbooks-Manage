<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaborContractStoreRequest extends FormRequest
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
            'labortype' => 'required',
            'fromdate' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'labortype.required' => "Bạn chưa chọn loại hợp đồng. Vui lòng chọn lại trong danh sách.",
            'fromdate.required' => "Bạn chưa nhập ngày bắt đầu hiệu lực. Vui lòng nhập lại.",
        ];
    }      
    
}
