<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationFunctionGroupsStoreRequest extends FormRequest
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
            'name' => 'required',
            'displayorder' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => "Bạn chưa nhập tên nhóm chức năng. Vui lòng nhập lại.",
            'displayorder.required' => "Bạn chưa nhập thứ tự hiển thị. Vui lòng nhập lại.",
        ];
    }     
}
