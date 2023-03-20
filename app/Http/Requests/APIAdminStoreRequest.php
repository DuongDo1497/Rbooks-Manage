<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIAdminStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
