<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisciplineStoreRequest extends FormRequest
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
            'fromdate' => 'required',
            'disciplinenumber' => 'required',
            'contentdiscipline' => 'required',            
        ];
    }

    public function messages()
    {
        return [
            'disciplinenumber.required' => "Bạn chưa nhập số quyết định khen thưởng/kỷ luật. Vui lòng nhập lại.",
            'fromdate.required' => "Bạn chưa nhập ngày hiệu lực. Vui lòng nhập lại.",
            'contentdiscipline.required' => "Bạn chưa nhập nội dung khen thưởng/kỷ luật. Vui lòng nhập lại.",
        ];
    }     
}
