<?php

namespace App\Http\Controllers\TaskManage\TaskTwo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use App\Http\Requests\TaskOneStoreRequest;
use RBooks\Services\LicenseTwoService;
use RBooks\Repositories\TaskWaitReceiveRepository;
use App\Constants\NotificationMessage;
use RBooks\Repositories\EmployeeRepository;
use \Auth;

class LicenseTwoController extends Controller
{
    public function __construct(LicenseTwoService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.tasktwos.license.');
        $this->setRoutePrefix('task_twos-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->taskWaits = app(TaskWaitReceiveRepository::class)->get()->where('module_id', 14)->where('roman_numerals', 'XII');

        $this->view->collections = $this->main_service->getAll()->where('module_id', 14)->where('module_type', 2);
        // Setup title
        $this->view->setSubHeading('Lưu đồ 2');

        if(Auth::user()->id == 1 || Auth::user()->id == 247 || Auth::user()->roles()->first()->name == 'owner') {
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
        $this->view->taskLicense = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(TaskOneUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    // 3. Leader giao Task
    public function LeadAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeRepository::class)->get()->whereIn('id', [1, 15]);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 14;

        $this->view->setSubHeading('Chi tiết (Leader Bản quyền giao Task)');
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

        $this->view->employees = app(EmployeeRepository::class)->get()->whereIn('id', [1, 15]);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 14;

        $this->view->setSubHeading('Chi tiết (Nhân viên Bản quyền nhận Task)');

        return $this->view('detail.detail4UserReceive');    
    }

    // 6. Leader duyệt Task
    public function LeadApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeRepository::class)->get()->whereIn('id', [1, 15]);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 14;

        $this->view->setSubHeading('Chi tiết (Leader Bản quyền duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail6LeadApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 7. Leader báo cáo Task CEO
    public function LeadReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeRepository::class)->get()->whereIn('id', [1, 15]);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 14;

        $this->view->setSubHeading('Chi tiết (Leader Bản quyền báo cáo Task CEO)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail7LeadReport');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 8. CEO duyệt Task
    public function CEOApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeRepository::class)->get()->whereIn('id', [1, 15]);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 14;

        $this->view->setSubHeading('Chi tiết (CEO duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail8CEOApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 9. Leader bàn giao Task cho bộ phận khác
    public function CEOAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeRepository::class)->get()->whereIn('id', [1, 15]);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->division = 14;

        $this->view->setSubHeading('Chi tiết (CEO bàn giao Task cho bộ phận khác)');
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
