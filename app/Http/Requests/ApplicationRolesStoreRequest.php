<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRolesStoreRequest extends FormRequest
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
            'name' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'code.required' => "Bạn chưa nhập mã role chức năng. Vui lòng nhập lại.",
            'name.required' => "Bạn chưa nhập tên role chức năng. Vui lòng nhập lại.",
        ];
    }     
}
