<?php

namespace App\Http\Controllers\TaskManage\TaskProduct;

use Illuminate\Http\Request;
use App\Constants\NotificationMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\DesignProductService;
use RBooks\Services\EmployeeService;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use \Auth;

class DesignProductController extends Controller
{
    public function __construct(DesignProductService $service)
    {
        parent::__construct($service);

        $this->view->statusTask = config('rbooks.STATUS_TASK');
        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 3);

        $this->setViewPrefix('task-manage.task_product.design.');
        $this->setRoutePrefix('product-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {
        $this->view->collections = $this->main_service->getAll()->where('module_id', 3)->where('module_type', 25);
        // Setup title
        $this->view->setSubHeading('Design');

        if(Auth::user()->employee()->first()->division()->first()->code_division == 'DESIGN' || Auth::user()->roles()->first()->name == 'owner') {
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
        $this->view->taskDesign = $this->main_service->find($id);
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

    // 2 .Chi tiết Leader duyệt
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

    // Chi tiết Leader phân công
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
