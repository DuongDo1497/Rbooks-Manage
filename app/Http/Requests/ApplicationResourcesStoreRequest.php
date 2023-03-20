<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationResourcesStoreRequest extends FormRequest
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
            'code.required' => "Bạn chưa nhập mã trang truy cập. Vui lòng nhập lại.",
            'name.required' => "Bạn chưa nhập tên trang truy cập. Vui lòng nhập lại.",
        ];
    }     
}
