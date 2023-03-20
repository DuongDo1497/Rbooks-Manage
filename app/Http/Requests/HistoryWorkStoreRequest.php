<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryWorkStoreRequest extends FormRequest
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
            'department_id' => 'required',
            'position_id' => 'required',
            'nummonths' => 'required',
            'fromdate' => 'required',
            'todate' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'department_id.required' => "Bạn chưa chọn phòng ban. Vui lòng chọn lại trong danh sách.",
            'position_id.required' => "Bạn chưa chọn chức vụ. Vui lòng chọn lại trong danh sách.",
            'nummonths.required' => "Bạn chưa nhập số tháng làm việc. Vui lòng nhập lại.",
            'fromdate.required' => "Bạn chưa nhập ngày bắt đầu. Vui lòng nhập lại.",
            'todate.required' => "Bạn chưa nhập ngày kết thúc. Vui lòng nhập lại.",
        ];
    }        
}
