<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SecurityResourcesStoreRequest extends FormRequest
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
            'rolecode' => 'required',
            'resourcecode' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'rolecode.required' => "Bạn chưa nhập mã role. Vui lòng nhập lại.",
            'resourcecode.required' => "Bạn chưa nhập trang truy cập. Vui lòng nhập lại.",
        ];
    }     
}
