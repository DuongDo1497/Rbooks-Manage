<?php

namespace App\Http\Controllers\TaskManage\TaskOther;

use Illuminate\Http\Request;
use App\Constants\NotificationMessage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\LanguageOtherService;
use RBooks\Services\EmployeeService;
use RBooks\Repositories\TaskChildRepository;
use RBooks\Repositories\TaskOneRepository;
use \Auth;

class LanguageOtherController extends Controller
{
    public function __construct(LanguageOtherService $service)
    {
        parent::__construct($service);

        $this->view->statusTask = config('rbooks.STATUS_TASK');
        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 10);
        $this->view->division = 15;

        $this->setViewPrefix('task-manage.taskothers.language.');
        $this->setRoutePrefix('task_other-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {
        $this->view->collections = $this->main_service->getAll()->where('module_id', 15)->where('module_type', 10);
        // Setup title
        $this->view->setSubHeading('Khác');

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
        $this->view->taskLanguage = $this->main_service->find($id);
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
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (User khởi tạo)');
        return $this->view('detail.detail1User');
    }

    // Chi tiết Leader duyệt
    public function LeadApprove(Request $request, $id)
    {
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (Leader duyệt)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail2LeadApprove');   
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    // Chi tiết CEO duyệt
    public function CEOApprove(Request $request, $id)
    {
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
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (Leader phân công)');
        if(Auth::user()->roles()->first()->name == "owner" || Auth::user()->roles()->first()->name == "Leader") {
            return $this->view('detail.detail4LeadAssign');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    // User nhận
    public function UserReceive(Request $request, $id)
    {
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (User nhận)');
        return $this->view('detail.detail5UserReceive');
    }
    // Leader duyệt báo cáo
    public function LeadApproveReport(Request $request, $id)
    {
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
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (CEO duyệt báo cáo)');
        if(Auth::user()->roles()->first()->name == "owner") {
            return $this->view('detail.detail8CEOApprove');    
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }
}
