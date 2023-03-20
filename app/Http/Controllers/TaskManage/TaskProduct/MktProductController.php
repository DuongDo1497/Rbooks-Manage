<?php

namespace App\Http\Controllers\TaskManage\TaskProduct;

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

class MktProductController extends Controller
{
    public function __construct(TaskOneService $service)
    {
        parent::__construct($service);

        $this->view->statusTask = config('rbooks.STATUS_TASK_OTHER');
        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 6);

        $this->setViewPrefix('task-manage.task_product.marketing.');
        $this->setRoutePrefix('product-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {
        $this->view->collections = $this->main_service->getAll()->where('module_id', 6)->where('module_type', 25);
        // Setup title
        $this->view->setSubHeading('Marketing');

        if(Auth::user()->employee()->first()->division()->first()->code_division == 'MARKETING' || Auth::user()->roles()->first()->name == 'owner') {
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
        $this->view->taskMkt = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(TaskOneUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }
    // Leader giao Task
    public function LeadAssign(Request $request, $id)
    {
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (Leader Marketing giao Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail3LeadAssign');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // User nhận Task
    public function UserReceive(Request $request, $id)
    {
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (Nhân viên Marketing nhận Task)');
        return $this->view('detail.detail4UserReceive');    
    }
    // Leader duyệt Task
    public function LeadApprove(Request $request, $id)
    {

        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (Leader Marketing duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail6LeadApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }

    // 7. CEO duyệt Task
    public function CEOApproveReport(Request $request, $id)
    {
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (CEO duyệt Task)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail7CEOApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        } 
    }
}
