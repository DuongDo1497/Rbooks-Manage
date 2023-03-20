<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DisciplineStoreRequest;
use RBooks\Services\DisciplineService;
use App\Constants\NotificationMessage;
use RBooks\Models\Disciplines;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class DisciplineController extends Controller
{
    public function __construct(DisciplineService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('user-employees.discipline.');
        $this->setRoutePrefix('disciplines-');
        $this->view->setHeading('home.Thông tin khen thưởng / kỷ luật');
    }

    public function index(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $employee = app(Employee::class)->find($employeeid_decrypt);
        $this->view->employee = $employee;

        $disciplinetype = config('rbooks.DISCIPLINETYPE');
        $this->view->disciplinetype = $disciplinetype;

        $this->view->collections = $this->main_service->getDisciplines($employeeid_decrypt);
        $this->view->setSubHeading('home.Danh sách khen thưởng / kỷ luật');
        return $this->view('index');
    }

    public function addDiscipline(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $disciplinetype = config('rbooks.DISCIPLINETYPE');

        $this->view->employeeid = $employeeid;
        $this->view->disciplinetype = $disciplinetype;

        $this->view->setSubHeading('home.Tạo mới dữ liệu');

        return $this->view('add');
    }

    public function store(DisciplineStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function editDiscipline(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $disciplinetype = config('rbooks.DISCIPLINETYPE');
        $this->view->disciplinetype = $disciplinetype;

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

    public function deleteDiscipline(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $id = $request->id;

        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . 'index', ['employeeid' => $employeeid])->with(NotificationMessage::DELETE_SUCCESS);
    }
}
