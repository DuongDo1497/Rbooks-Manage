<?php

namespace App\Http\Controllers\TaskManage\TaskOne;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\CEOOneService;
use RBooks\Repositories\EmployeeRepository;
use App\Constants\NotificationMessage;
use App\Http\Controllers\TaskManage\TaskOne\TaskOneController;
use RBooks\Repositories\TaskWaitReceiveRepository;
use \Auth;

class CEOOneController extends Controller
{
    public function __construct(CEOOneService $service)
    {
        parent::__construct($service);
        $this->view->statusTask = config('rbooks.STATUS_TASK_CEO');
        $this->view->employees = app(EmployeeRepository::class)->get()->where('id', 23);
        $this->view->division = 16;

        $this->setViewPrefix('task-manage.taskones.ceo.');
        $this->setRoutePrefix('ceo-ones-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {
        $this->view->collections = $this->main_service->getAll()->where('module_id', 1)->where('module_type', 16);
        // Setup title
        $this->view->setSubHeading('CEO');

        return $this->view('index');
    }

    public function store(TaskOneStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->taskCEO = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(TaskOneUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    // 1. Task Of CEO
    public function TaskOfLead(Request $request, $id)
    {
        $this->view->detailTask = app(TaskWaitReceiveRepository::class)->find($id);
        $this->view->setSubHeading('Chi tiết (Task của CEO)');
        return $this->view('detail.taskOfCEO');    
    }

    // 2. CEO tạo Task và thực hiện
    public function CEOCreatePerform(Request $request, $id)
    {
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (CEO tạo và thực hiện công việc)');
        return $this->view('detail.CEO2Create&Perform');   
    }

    // 3. CEO xác nhận hoàn thành Task
    public function CEOAccept(Request $request, $id)
    {
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (CEO xác nhận hoàn thành công việc)');
        return $this->view('detail.CEO3Accept');   
    }

    // 4. CEO bàn giao Task cho bộ phận khác
    public function CEOAssign(Request $request, $id)
    {
        $this->view->detailTask = app(TaskOneController::class)->generalDetail($id);
        $this->view->setSubHeading('Chi tiết (CEO bàn giao công việc cho bộ phận khác)');
        return $this->view('detail.CEO4Assign');   
    }

    // 5. CEO bàn giao
    public function CEOAssignDivision(Request $request, $id)
    {
        $this->main_service->CEOAssignDivision($request, $id);
        return redirect()->back()->with(NotificationMessage::APPROVE_SUCCESS);
    }
}
