<?php

namespace App\Http\Controllers\TaskManage\TaskSachRB2;

use Illuminate\Http\Request;
use App\Constants\NotificationMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\DesignSachRb2Service;
use RBooks\Services\EmployeeService;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use RBooks\Repositories\TaskWaitReceiveRepository;
use \Auth;

class DesignSachRb2Controller extends Controller
{
    public function __construct(DesignSachRb2Service $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.task_sach_rbooks.design2.');
        $this->setRoutePrefix('sach_rbooks_2-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->taskWaits = app(TaskWaitReceiveRepository::class)->get()->where('module_id', 3)->where('module_type', 17)->where('roman_numerals', 'XVI');

        $this->view->collections = $this->main_service->getAll()->where('module_id', 3)->where('module_type', 17);
        // Setup title
        $this->view->setSubHeading('IT');

        if(Auth::user()->employee()->first()->division()->first()->code_division == 'DESIGN' || Auth::user()->roles()->first()->name == 'owner') {
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
        $this->view->taskDesign = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(TaskOneUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    // 1. Task của Leader
    public function TaskOfLead(Request $request, $id)
    {
        $this->view->detailTask = app(TaskWaitReceiveRepository::class)->find($id);

        $this->view->setSubHeading('Chi tiết (Công việc CEO phân công)');
        return $this->view('detail.taskOfLead');

    }

    // 3. Chi tiết Leader phân công
    public function LeadAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 3);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader phân công)');

        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail3LeadAssign');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }

    }

    // 4. User nhận
    public function UserReceive(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 3);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (User nhận)');
        return $this->view('detail.detail4UserReceive');

    }

    // 5. User báo cáo
    public function UserReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 3);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (User báo cáo)');
        return $this->view('detail.detail5UserReport');

    }

    // 6. Leader duyệt báo cáo
    public function LeadApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 3);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader duyệt báo cáo)');

        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail6LeadApprove');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    // 7. CEO duyệt báo cáo 
    public function CEOApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 3);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO duyệt báo cáo)');

        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail7CEOApprove');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    // 8. CEO phân công BP khác
    public function CEOAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 3);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO phân công bộ phận khác)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail8CEOAssign');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }

    }

    // 9. CEO bàn giao
    public function CEOAssignDivision(Request $request, $id)
    {
        $this->main_service->CEOAssignDivision($request, $id);
        return redirect()->back()->with(NotificationMessage::APPROVE_SUCCESS);
    }
}
