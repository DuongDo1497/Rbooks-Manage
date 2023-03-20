<?php

namespace App\Http\Controllers\TaskManage\TaskTwo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use App\Http\Requests\TaskOneStoreRequest;
use RBooks\Services\TranslateTwoService;
use RBooks\Services\EmployeeService;
use RBooks\Repositories\TaskWaitReceiveRepository;
use App\Constants\NotificationMessage;
use \Auth;

class TranslateTwoController extends Controller
{
    public function __construct(TranslateTwoService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.tasktwos.translate.');
        $this->setRoutePrefix('task_twos-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->taskWaits = app(TaskWaitReceiveRepository::class)->get()->where('module_id', 11)->where('roman_numerals', 'III');

        $this->view->collections = $this->main_service->getAll()->where('module_id', 11)->where('module_type', 2)->where('roman_numerals', 'III');
        // Setup title
        $this->view->setSubHeading('Biên dịch');

        if(Auth::user()->id == 247 || Auth::user()->roles()->first()->name == 'owner') {
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

        $this->view->setSubHeading('Chi tiết (công việc của Leader)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.taskOfLead');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 3. Leader thực hiện Task
    public function LeadPerform(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 15);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader thực hiện công việc)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail3LeadPerform');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 4. Leader báo cáo
    public function LeadReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 15);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader báo cáo công việc)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail4LeadReport');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    // 5. CEO duyệt nhận Task
    public function CEOApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 15);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO duyệt nhận báo cáo công việc)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail5CEOApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    // 6. CEO bàn giao bộ phận khác
    public function CEOAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 15);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO phân công/bàn giao bộ phận khác)');
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
