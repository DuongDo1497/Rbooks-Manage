<?php

namespace App\Http\Controllers\TaskManage\TaskSachRBooks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\TaskOneService;
use RBooks\Services\EmployeeService;
use App\Constants\NotificationMessage;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use RBooks\Repositories\TaskWaitReceiveRepository;
use \Auth;

class AccountSachRBController extends Controller
{
    public function __construct(TaskOneService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.task_sach_rbooks.account.');
        $this->setRoutePrefix('sach_rbooks_1-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->taskWaits = app(TaskWaitReceiveRepository::class)->get()->where('module_id', 5)->where('module_type', 16)->where('roman_numerals', 'XIII');

        $this->view->collections = $this->main_service->getAll()->where('module_id', 5)->where('module_type', 16);
        // Setup title
        $this->view->setSubHeading('Kế toán');

        if(Auth::user()->employee()->first()->division()->first()->code_division == 'KETOAN' || Auth::user()->roles()->first()->name == 'owner') {
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
        $this->view->taskTranslate = $this->main_service->find($id);
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

        $this->view->setSubHeading('Chi tiết (Task của Leader Kế toán)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.taskOfLead');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 2. Leader nhận Task
    public function LeadReceive(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 5);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Leader Kế toán nhận Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail2LeadReceive');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 3. Leader giao Task
    public function LeadAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 5);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Leader Kế toán giao Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail3LeadAssign');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 4. User nhận Task
    public function UserReceive(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 5);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Nhân viên Kế toán nhận Task)');

        return $this->view('detail.detail4UserReceive');    
    }

    // 5. User thực hiện Task
    public function UserReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 5);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Nhân viên Kế toán thực hiện Task)');

        return $this->view('detail.detail5UserReport');   
    }

    // 6. Leader duyệt Task
    public function LeadApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 5);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Leader Kế toán duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail6LeadApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 8. CEO duyệt Task
    public function CEOApproveReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 5);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (CEO duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail7CEOApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }
}
