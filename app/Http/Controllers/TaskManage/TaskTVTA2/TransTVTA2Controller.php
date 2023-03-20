<?php

namespace App\Http\Controllers\TaskManage\TaskTVTA2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use App\Http\Requests\TaskOneStoreRequest;
use RBooks\Services\TransTVTA2Service;
use RBooks\Repositories\TaskWaitReceiveRepository;
use App\Constants\NotificationMessage;
use RBooks\Services\EmployeeService;
use \Auth;

class TransTVTA2Controller extends Controller
{
    public function __construct(TransTVTA2Service $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.task_tv_ta.translate2.');
        $this->setRoutePrefix('tv_ta_2-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        // $this->view->taskWaits = app(TaskWaitReceiveRepository::class)->get()->where('module_id', 11)->where('module_type', 21)->where('roman_numerals', 'I');

        $this->view->collections = $this->main_service->getAll()->where('module_id', 11)->where('module_type', 21);
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

    // 3. Leader thực hiện Task
    public function LeadPerform(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 15);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader thực hiện công việc)');

        return $this->view('detail.detail3LeadPerform');   
    }

    // 5. CEO duyệt nhận Task
    public function CEOAccept(Request $request, $id)
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

    // 6. US Editor
    public function USEditor(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 15);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (US Editor)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail6USEditor');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    // 7. CEO bàn giao bộ phận khác
    public function CEOAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_LAYOUT');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 15);

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO phân công/bàn giao bộ phận khác)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail7CEOAssign');
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
