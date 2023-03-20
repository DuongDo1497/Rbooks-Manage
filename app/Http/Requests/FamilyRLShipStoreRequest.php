<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyRLShipStoreRequest extends FormRequest
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
            'relation' => 'required',
            'fullname' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'relation.required' => "Bạn chưa chọn loại quan hệ nhân thân. Vui lòng chọn lại trong danh sách.",
            'fullname.required' => "Bạn chưa nhập họ tên. Vui lòng nhập lại.",
        ];
    }     
}
