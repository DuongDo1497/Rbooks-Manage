<?php

namespace App\Http\Controllers\TaskManage\TaskProjectRB;

use Illuminate\Http\Request;
use App\Constants\NotificationMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\ItProjectRBService;
use RBooks\Services\EmployeeService;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use \Auth;

class ItProjectRBController extends Controller
{
    public function __construct(ItProjectRBService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.task_rb.it.');
        $this->setRoutePrefix('projects_rb-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->collections = $this->main_service->getAll()->where('module_id', 4)->where('module_type', 11);
        // Setup title
        $this->view->setSubHeading('Project RB');

        if(Auth::user()->employee()->first()->division()->first()->code_division == 'IT' || Auth::user()->roles()->first()->name == 'owner') {
            return $this->view('index');
        }
        else {
            return redirect()->back()->with('success', 'Bạn không có quyền truy cập !!!.');
        }
    }

    public function store(TaskOneStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->taskIT = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(TaskOneUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    // 1. Chi tiết User khởi tạo
    public function taskDetail1UserCreate(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 4);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (User khởi tạo)');
        return $this->view('detail.detail1User');

    }

    // 2 .Chi tiết Leader duyệt
    public function LeadApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 4);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader duyệt)');

        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail2LeadApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }

    }

    // 3 .Chi tiết CEO duyệt
    public function CEOApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 4);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO duyệt)');

        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail3CEOApprove');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }

    }

    // 4 .Chi tiết Leader phân công
    public function LeadAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 4);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader phân công)');

        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail4LeadAssign');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }

    }

    // 5 . User nhận
    public function UserReceive(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 4);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (User nhận)');
        return $this->view('detail.detail5UserReceive');

    }

    // 6. User báo cáo
    public function UserReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 4);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (User báo cáo)');
        return $this->view('detail.detail6UserReport');

    }

    // 7. Leader duyệt báo cáo
    public function LeadApproveReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 4);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader duyệt báo cáo)');

        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail7LeadApprove');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    // 8. CEO duyệt báo cáo 
    public function CEOApproveReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 4);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO duyệt báo cáo)');

        if($request->two) {
            return $this->view('Two.task6CEOApprove');
        } else {
            if(Auth::user()->roles()->first()->name == "owner") {
                return $this->view('detail.detail8CEOApprove');    
            } else {
                return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
            }
        }
    }

    // 9. CEO phân công BP khác
    public function CEOAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 4);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO phân công bộ phận khác)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail9CEOAssign');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }

    }

    // 10. CEO bàn giao
    public function CEOAssignDivision(Request $request, $id)
    {
        $this->main_service->CEOAssignDivision($request, $id);
        return redirect()->back()->with(NotificationMessage::APPROVE_SUCCESS);
    }
}
