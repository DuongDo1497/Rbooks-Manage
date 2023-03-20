<?php

namespace App\Http\Controllers\TaskManage\TaskOne;

use Illuminate\Http\Request;
use App\Constants\NotificationMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use App\Http\Requests\TaskOneUpdateRequest;
use RBooks\Services\TaskOneService;
use RBooks\Services\EmployeeService;
use RBooks\Services\DivisionService;
use RBooks\Repositories\TaskChildRepository;
use RBooks\Repositories\TaskOneRepository;
use \Auth;

class TaskOneController extends Controller
{
    public function __construct(TaskOneService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.taskones.');
        $this->setRoutePrefix('task_ones-');

        $this->view->setHeading('Task-Manage');
    }

    public function store(TaskOneStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {

    }

    public function update(TaskOneUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function delete($id)
    {
        $this->main_service->delete($id);
        return redirect()->back()->with(NotificationMessage::DELETE_SUCCESS);
    }

    // leader nhận 1 Task
    public function receiveTask($id)
    {
        $this->main_service->receiveTask($id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // Duyệt Task
    public function ApproveTask(Request $request, $id)
    {   
        $this->main_service->ApproveTask($request, $id);
        return redirect()->back()->with(NotificationMessage::APPROVE_SUCCESS);
    }

    // Leader báo cáo CEO (lưu đồ 2)
    public function ApproveTaskTwo(Request $request, $id)
    {
        $this->main_service->ApproveTaskTwo($request, $id);
        return redirect()->back()->with(NotificationMessage::APPROVE_SUCCESS);
    }

    // Start Lấy DS NV và chi tiết task
    public function generalDetail($id)
    {
        return $this->main_service->find($id);
    }

    // Lấy DS NV
    public function generalEmployee($id)
    {
        $task_moduleid = app(TaskOneRepository::class)->first()->where('id', $id)->first();

        return app(EmployeeService::class)->getAll()->where('division_id', $task_moduleid->division_id);
    }

    // Lấy roles User đăng nhập
    public function roleEmployee()
    {
        $roleEmployee = Auth::user()->roles()->first();
        return $roleEmployee;   
    }
    // End
}
