<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationModulesStoreRequest extends FormRequest
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
            'code' => 'required',
            'applicationmodulename' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'code.required' => "Bạn chưa nhập mã module chức năng. Vui lòng nhập lại.",
            'applicationmodulename.required' => "Bạn chưa nhập tên module chức năng. Vui lòng nhập lại.",
        ];
    }     
}
