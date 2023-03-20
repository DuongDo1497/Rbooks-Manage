<?php

namespace App\Http\Controllers\TaskManage\TaskOther;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\TransOtherService;
use RBooks\Repositories\EmployeeRepository;

use \Auth;

class TransOtherController extends Controller
{
    public function __construct(TransOtherService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.taskothers.translate.');
        $this->setRoutePrefix('task_other-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->collections = $this->main_service->getAll()->where('module_id', 11)->where('module_type', 10);
        // Setup title
        $this->view->setSubHeading('Lưu đồ khác');

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

    // 1. Chi tiết User khởi tạo
    public function taskDetail1UserCreate(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (User khởi tạo)');
        return $this->view('detail.detail1User');

    }

    // 2 .Chi tiết Leader duyệt
    public function LeadApprove(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

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

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

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

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

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

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (User nhận)');
        return $this->view('detail.detail5UserReceive');

    }

    // 6. User báo cáo
    public function UserReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (User báo cáo)');
        return $this->view('detail.detail6UserReport');

    }

    // 7. Leader duyệt báo cáo
    public function LeadApproveReport(Request $request, $id)
    {
        $this->view->statusTask = config('rbooks.STATUS_TASK');

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

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

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);

        $this->view->setSubHeading('Chi tiết (CEO duyệt báo cáo)');

        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail8CEOApprove');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }
}
