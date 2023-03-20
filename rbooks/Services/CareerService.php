<?php

namespace RBooks\Services;

use RBooks\Repositories\CareerRepository;
use \Auth;
use \DB;

class CareerService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(CareerRepository::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Recruitment
     */
    public function create($request)
    {
        $file = $request->file('file_cv');
        if($file == null) {
            $file = 'cv_apply/';
            $file_cvPDF = substr($file, 8);
        } else {
            $file_cv = $file->getClientOriginalName();
            $file_cvPDF = 'cv_apply/'.$file_cv;
            $file->move(public_path('cv_apply/'), $file_cvPDF);
        }

        $data = [
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
            'apply_position' => $request->apply_position,
            'file_cv' => $file_cvPDF,
            'status' => 0,
            'updated_user_id' => Auth::user()->id
        ];
        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $career = $this->repository->find($id);

        $file = $request->file('file_cv');

        if($file == null) {
            $file = 'cv_apply/'.$career->file_cv;
            $file_cvPDF = substr($file, 9);
        } else {
            $file_cv = $file->getClientOriginalName();
            $file_cvPDF = 'cv_apply/'.$file_cv;
            $file->move(public_path('cv_apply/'), $file_cvPDF);
        }
        $data = [
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
            'apply_position' => $request->apply_position,
            'file_cv' => $file_cvPDF,
            'status' => $request->status,
            'updated_user_id' => Auth::user()->id
        ];

        return $this->repository->update($data, $id);
    }
}
