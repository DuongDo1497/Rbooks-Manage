<?php

namespace App\Http\Controllers\TaskManage\TaskSachRB3;

use Illuminate\Http\Request;
use App\Constants\NotificationMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\WritingSachRb3Service;
use RBooks\Services\EmployeeService;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use RBooks\Repositories\TaskWaitReceiveRepository;
use \Auth;

class WritingSachRb3Controller extends Controller
{
    public function __construct(WritingSachRb3Service $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.task_sach_rbooks.writing3.');
        $this->setRoutePrefix('sach_rbooks_2-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->taskWaits = app(TaskWaitReceiveRepository::class)->get()->where('module_id', 10)->where('module_type', 18)->where('roman_numerals', 'XVII');

        $this->view->collections = $this->main_service->getAll()->where('module_id', 10)->where('module_type', 18);
        // Setup title
        $this->view->setSubHeading('Writing');

        if(Auth::user()->employee()->first()->division()->first()->code_division == 'WRITING' || Auth::user()->roles()->first()->name == 'owner') {
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

    // 3. Chi tiết Leader phân công
    public function LeadAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 10);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 10;

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

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 10);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 10;

        $this->view->setSubHeading('Chi tiết (User nhận)');
        return $this->view('detail.detail4UserReceive');

    }

    // 6. Leader duyệt báo cáo
    public function LeadApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 10);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 10;

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

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 10);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 10;

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

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 10);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 10;

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
