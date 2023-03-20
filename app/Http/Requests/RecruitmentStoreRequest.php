<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecruitmentStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'vacancies' => 'required|unique:recruitments|max:255',
            'quantity' => 'required|max:255',
            'application_deadline' => 'required|max:255',
            'introduction' => 'required',
            'benefit' => 'required|max:255',
            'address' => 'required',
            'salary' => 'required|max:255',
            'work_time' => 'required|max:255',
            'experience' => 'required',
            'requirements' => 'required',
            'orther_requirements' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'unique' => 'Vị trí tuyển dụng(ENG) đã tồn tại trên hệ thống',
            'number' => 'la so',
        ];
    }
}
