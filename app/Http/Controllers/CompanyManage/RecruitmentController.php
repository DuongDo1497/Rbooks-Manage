<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecruitmentStoreRequest;
use RBooks\Models\Job_description;
use RBooks\Models\Recruitment;
use RBooks\Services\RecruitmentService;
use App\Constants\NotificationMessage;

class RecruitmentController extends Controller
{
    public function __construct(RecruitmentService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.recruitment.');
        $this->setRoutePrefix('recruitments-');

        $this->view->setHeading('Quản lý tin tuyển dụng');
    }

    public function store(RecruitmentStoreRequest $request)
    {

        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->recruitment = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function UpLoadStatus($id)
    {

        $recruitment = Recruitment::find($id);

        if ($recruitment->status == 0) {
            $recruitment->status = 1;
        } elseif ($recruitment->status == 1) {
            $recruitment->status = 2;
        } elseif ($recruitment->status == 2) {
            $recruitment->status = 0;
        }

        $recruitment->save();

        return back();
    }

    public function destroy($id)
    {

        Recruitment::destroy($id);
        $data =  Job_description::where('recruitment_id', $id)->delete();

        return redirect()->route($this->route_prefix . 'index')->with(NotificationMessage::DELETE_SUCCESS);
    }
}
