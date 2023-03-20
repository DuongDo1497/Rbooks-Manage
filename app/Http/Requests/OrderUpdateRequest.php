<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'name_delivery'=>'required|max:255';
            'phone_delivery'=>'required';
            'city_delivery'=>'required|max:50';
            'district_delivery'=>'required|max:50';
            'address_delivery'=>'required';
            'name_billing'=>'required';
            'phone_billing'=>'required';
            'city_billing'=>'required|max:50';
            'district_billing'=>'required|max:50';
            'address_billing'=>'required';
        ];
    }
}
