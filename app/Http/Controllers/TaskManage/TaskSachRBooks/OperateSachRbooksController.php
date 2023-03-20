<?php

namespace App\Http\Controllers\TaskManage\TaskSachRBooks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\OperateSachRbooksService;
use RBooks\Services\EmployeeService;
use App\Constants\NotificationMessage;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use RBooks\Repositories\TaskWaitReceiveRepository;
use \Auth;

class OperateSachRbooksController extends Controller
{
    public function __construct(OperateSachRbooksService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.task_sach_rbooks.operate.');
        $this->setRoutePrefix('sach_rbooks_1-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->taskWaits = app(TaskWaitReceiveRepository::class)->get()->where('module_id', 9)->where('module_type', 16)->whereIn('roman_numerals', ['XI', 'X', 'XII']);

        $this->view->collections = $this->main_service->getAll()->where('module_id', 9)->where('module_type', 16);
        // Setup title
        $this->view->setSubHeading('Vận hành');

        if(Auth::user()->employee()->first()->division()->first()->code_division == 'VANHANH' || Auth::user()->roles()->first()->name == 'owner') {
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
        $this->view->taskOperate = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(TaskOneUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    // 1. Task Of Leader
    public function TaskOfLead(Request $request, $id)
    {
        $this->view->detailTask = app(TaskWaitReceiveRepository::class)->find($id);

        $this->view->setSubHeading('Chi tiết (Task của Leader Vận hành)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.taskOfLead');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 2. Leader nhận Task
    public function LeadReceive(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 9);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader Vận hành nhận Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail2LeadReceive');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 3. Leader thực hiện Task
    public function LeadPerform(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 9);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader thực hiện Task)');

        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail3LeadPerform');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    // 4. Leader báo cáo Task CEO
    public function LeadReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 9);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader báo cáo Task CEO)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail4LeadReport');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 5. CEO duyệt Task
    public function CEOApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 9);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail5CEOApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 6. Leader bàn giao Task cho bộ phận khác
    public function CEOAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 9);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO bàn giao Task cho bộ phận khác)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail6CEOAssign');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 7. CEO bàn giao
    public function CEOAssignDivision(Request $request, $id)
    {
        $this->main_service->CEOAssignDivision($request, $id);
        return redirect()->back()->with(NotificationMessage::APPROVE_SUCCESS);
    }
}
