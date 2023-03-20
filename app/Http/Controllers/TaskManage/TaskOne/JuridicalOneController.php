<?php

namespace App\Http\Controllers\TaskManage\TaskOne;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\JuridicalOneService;
use \Auth;

class JuridicalOneController extends Controller
{
    public function __construct(JuridicalOneService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.taskones.juridical.');
        $this->setRoutePrefix('juridicals-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->collections = $this->main_service->getAll()->where('module_id', 17)->where('module_type', 1);
        // Setup title
        $this->view->setSubHeading('Lưu đồ 1');

        if(Auth::user()->employee()->first()->division()->first()->code_division == 'VANHANH' || Auth::user()->roles()->first()->name == 'owner') {
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
        $this->view->employees = app(TaskOneController::class)->generalEmployee($id);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Task của Leader Design)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.TaskOfLead');   
        } else {
            return redirect()->back()->with('success', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 2. Leader nhận Task
    public function LeadReceive(Request $request, $id)
    {
        $this->view->employees = app(TaskOneController::class)->generalEmployee($id);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Leader Design nhận Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail2LeadReceive');   
        } else {
            return redirect()->back()->with('success', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 3. Leader giao Task
    public function LeadAssign(Request $request, $id)
    {
        $this->view->employees = app(TaskOneController::class)->generalEmployee($id);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Leader Design giao Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail3LeadAssign');   
        } else {
            return redirect()->back()->with('success', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 4. User nhận Task
    public function UserReceive(Request $request, $id)
    {
        $this->view->employees = app(TaskOneController::class)->generalEmployee($id);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Nhân viên Design nhận Task)');

        return $this->view('detail.detail4UserReceive');    
    }

    // 5. User thực hiện Task
    public function UserReport(Request $request, $id)
    {
        $this->view->employees = app(TaskOneController::class)->generalEmployee($id);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Nhân viên Design thực hiện Task)');

        return $this->view('detail.detail5UserReport');   
    }

    // 6. Leader duyệt Task
    public function LeadApprove(Request $request, $id)
    {
        $this->view->employees = app(TaskOneController::class)->generalEmployee($id);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Leader Design duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail6LeadApprove');   
        } else {
            return redirect()->back()->with('success', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 7. Leader báo cáo Task CEO
    public function LeadReport(Request $request, $id)
    {
        $this->view->employees = app(TaskOneController::class)->generalEmployee($id);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (Leader Design báo cáo Task CEO)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail7LeadReport');   
        } else {
            return redirect()->back()->with('success', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 8. CEO duyệt Task
    public function CEOApprove(Request $request, $id)
    {
        $this->view->employees = app(TaskOneController::class)->generalEmployee($id);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (CEO duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail8CEOApprove');   
        } else {
            return redirect()->back()->with('success', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 9. Leader bàn giao Task cho bộ phận khác
    public function CEOAssign(Request $request, $id)
    {
        $this->view->employees = app(TaskOneController::class)->generalEmployee($id);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->roleEmployee = app(TaskOneController::class)->roleEmployee();

        $this->view->setSubHeading('Chi tiết (CEO bàn giao Task cho bộ phận khác)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail9CEOAssign');   
        } else {
            return redirect()->back()->with('success', 'Bạn không có quyền truy cập !!!.');
        } 
    }
}
