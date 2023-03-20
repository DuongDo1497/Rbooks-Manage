<?php

namespace App\Http\Controllers\TaskManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\TaskWaitReceiveService;
use RBooks\Services\EmployeeService;
use App\Constants\NotificationMessage;

class TaskWaitReceiveController extends Controller
{
    public function __construct(TaskWaitReceiveService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.taskwait.');
        $this->setRoutePrefix('taskWaits-');
    }

    public function store(DetailTaskStoreRequest $request)
    {
        return $this->_store($request);
    }

    // edit taskWait
    public function edit($id)
    {
        $this->view->taskWait = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa công việc giao');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        $this->main_service->update($request, $id);
        return redirect()->back()->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function delete($id)
    {
        $this->main_service->delete($id);
        return redirect()->back()->with(NotificationMessage::DELETE_SUCCESS);
    }

    // leader nhận 1 Task
    public function step1Receive($id)
    {
        $this->main_service->step1Receive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // leader nhận nhiều Task
    public function stepReceive($id)
    {
        $this->main_service->stepReceive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // leader biên dịch 2 nhận Task
    public function leadTranslateTwoReceive($id)
    {
        $this->main_service->leadTranslateTwoReceive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }
    // leader biên dịch dịch sách tv-ta nhận Task 2
    public function leadTransTVTA2Receive($id)
    {
        $this->main_service->leadTransTVTA2Receive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // leader vận hành nhận Task
    public function OperateReceive($id)
    {
        $this->main_service->OperateReceive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // leader sales nhận Task
    public function SalesReceive($id)
    {
        $this->main_service->SalesReceive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // leader bản quyền 2 nhận Task
    public function leadLicense2Receive($id)
    {
        $this->main_service->leadLicense2Receive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // leader In ấn nhận nhiều Task
    public function stepPrintReceive($id)
    {
        $this->main_service->stepPrintReceive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // Leader marketing2 nhận nhiều Task
    public function Markt2Receive($id)
    {
        $this->main_service->Markt2Receive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // Leader it_project_rb2 nhận nhiều Task
    public function leadITRB2Receive($id)
    {
        $this->main_service->leadITRB2Receive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // Leader operate rbooks nhận nhiều Task
    public function leadOperateRBReceive($id)
    {
        $this->main_service->leadOperateRBReceive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // Leader In ấn Sách Writing Rbooks nhận nhiều Task
    public function leadPrintRBReceive($id)
    {
        $this->main_service->leadPrintRBReceive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // Leader dàn trang dịch TV->TA nhận Task
    public function leadLayoutTVTAReceive($id)
    {
        $this->main_service->leadLayoutTVTAReceive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // leader marketing nhận Task sách writing rbooks
    public function leadMktRB2Receive($id)
    {
        $this->main_service->leadMktRB2Receive($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }
}
