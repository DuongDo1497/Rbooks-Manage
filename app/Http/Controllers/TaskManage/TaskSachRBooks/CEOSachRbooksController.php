<?php

namespace App\Http\Controllers\TaskManage\TaskSachRBooks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\CEOSachRbooksService;
use RBooks\Services\EmployeeService;
use App\Constants\NotificationMessage;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use RBooks\Repositories\TaskWaitReceiveRepository;
use \Auth;

class CEOSachRbooksController extends Controller
{
    public function __construct(CEOSachRbooksService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.task_sach_rbooks.ceo.');
        $this->setRoutePrefix('sach_rbooks_1-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK_CEO');

        $this->view->taskWaits = app(TaskWaitReceiveRepository::class)->get()->where('module_id', 16)->where('module_type', 16)->where('roman_numerals', 'III');

        $this->view->collections = $this->main_service->getAll()->where('module_id', 16)->where('module_type', 16);
        // Setup title
        $this->view->setSubHeading('CEO');

        if(Auth::user()->roles()->first()->name == 'owner') {
            return $this->view('index');
        }
        else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    public function store(TaskOneStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->taskCEO = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(TaskOneUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    // 1. Task Of CEO
    public function TaskOfLead(Request $request, $id)
    {
        $this->view->detailTask = app(TaskWaitReceiveRepository::class)->find($id);

        $this->view->setSubHeading('Chi tiết (Task của CEO)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.taskOfCEO');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 2. CEO tạo Task và thực hiện
    public function CEOCreatePerform(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_CEO');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 23);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 16;

        $this->view->setSubHeading('Chi tiết (CEO tạo và thực hiện công việc)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail2CEOAssign');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 3. CEO xác nhận hoàn thành Task
    public function CEOAccept(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_CEO');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 23);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 16;

        $this->view->setSubHeading('Chi tiết (CEO xác nhận hoàn thành công việc)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail3CEOApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 4. CEO bàn giao Task cho bộ phận khác
    public function CEOAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_CEO');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 23);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 16;

        $this->view->setSubHeading('Chi tiết (CEO bàn giao công việc cho bộ phận khác)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail4CEOAssign');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 5. CEO bàn giao
    public function CEOAssignDivision(Request $request, $id)
    {
        $this->main_service->CEOAssignDivision($request, $id);
        return redirect()->back()->with(NotificationMessage::APPROVE_SUCCESS);
    }
}
