<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HistoryWorkStoreRequest;
use RBooks\Services\HistoryWorkService;
use App\Constants\NotificationMessage;
use RBooks\Models\HistoryWorks;
use RBooks\Models\Employee;
use RBooks\Services\DepartmentService;
use RBooks\Services\PositionService;
use Illuminate\Support\Facades\Crypt;

class HistoryWorkController extends Controller
{
    public function __construct(HistoryWorkService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('user-employees.historywork.');
        $this->setRoutePrefix('historyworks-');
        $this->view->setHeading('home.Thông tin quá trình công tác nhân viên');
    }

    public function index(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $this->view->departments = app(DepartmentService::class)->getAll();
        $this->view->positions = app(PositionService::class)->getAll();

        $employee = app(Employee::class)->find($employeeid_decrypt);
        $this->view->employee = $employee;

        $this->view->collections = $this->main_service->getHistoryWorks($employeeid_decrypt);
        $this->view->setSubHeading('home.Danh sách quá trình làm việc nhân viên');
        return $this->view('index');
    }

    public function addHistoryWork(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;
        $this->view->departments = app(DepartmentService::class)->getAll();
        $this->view->positions = app(PositionService::class)->getAll();

        $this->view->setSubHeading('home.Tạo mới dữ liệu');

        return $this->view('add');
    }

    public function store(HistoryWorkStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function editHistoryWork(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;
        $this->view->departments = app(DepartmentService::class)->getAll();
        $this->view->positions = app(PositionService::class)->getAll();

        $id = $request->id;
        $this->view->model = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chỉnh sửa dữ liệu');

        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $this->view->employeeid = $employeeid;

        $model = $this->main_service->update($request, $id);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'edit', ['id' => $id])
                ->withErrors(NotificationMessage::UPDATE_ERROR);
        }

        return redirect()
            ->route($this->route_prefix . 'index', ['employeeid' => $employeeid])
            ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function deleteHistoryWork(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $id = $request->id;

        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . 'index', ['employeeid' => $employeeid])->with(NotificationMessage::DELETE_SUCCESS);
    }
}
