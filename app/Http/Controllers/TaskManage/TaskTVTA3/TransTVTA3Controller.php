<?php

namespace App\Http\Controllers\TaskManage\TaskTVTA3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\TaskOneService;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Repositories\EmployeeRepository;
use \Auth;

class TransTVTA3Controller extends Controller
{
    public function __construct(TaskOneService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.task_tv_ta.translate3.');
        $this->setRoutePrefix('tv_ta_3-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        // $this->view->taskWaits = app(TaskWaitReceiveRepository::class)->get()->where('module_id', 11)->where('module_type', 22)->where('roman_numerals', 'V');

        $this->view->collections = $this->main_service->getAll()->where('module_id', 11)->where('module_type', 22);
        // Setup title
        $this->view->setSubHeading('Biên dịch');

        if(Auth::user()->employee()->first()->division()->first()->code_division == 'BIENDICH' || Auth::user()->employee()->first()->where('id', 12) || Auth::user()->roles()->first()->name == 'owner') {
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

    // 3. Leader giao Task
    public function LeadAssign(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader Biên dịch giao Task)');
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

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Nhân viên Biên dịch nhận Task)');

        return $this->view('detail.detail4UserReceive');    
    }

    // 6. Leader duyệt Task
    public function LeadApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (Leader Biên dịch duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail6LeadApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 7. CEO duyệt Task
    public function CEOApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail7CEOApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }
}
