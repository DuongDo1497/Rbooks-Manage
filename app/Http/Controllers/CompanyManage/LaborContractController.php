<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LaborContractStoreRequest;
use RBooks\Services\LaborContractService;
use App\Constants\NotificationMessage;
use RBooks\Models\LaborContracts;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class LaborContractController extends Controller
{
    public function __construct(LaborContractService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('user-employees.laborcontract.');
        $this->setRoutePrefix('laborcontracts-');
        $this->view->setHeading('home.Thông tin hợp đồng lao động nhân viên');
    }

    public function index(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $employee = app(Employee::class)->find($employeeid_decrypt);
        $this->view->employee = $employee;

        $labortype = config('rbooks.LABORTYPE');
        $this->view->labortype = $labortype;

        $this->view->collections = $this->main_service->getLaborContracts($employeeid_decrypt);
        $this->view->setSubHeading('home.Danh sách hợp đồng lao động');
        return $this->view('index');
    }

    public function addLaborContract(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $labortype = config('rbooks.LABORTYPE');

        $this->view->employeeid = $employeeid;
        $this->view->labortype = $labortype;

        $this->view->setSubHeading('home.Tạo mới dữ liệu');

        return $this->view('add');
    }

    public function store(LaborContractStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function editLaborContract(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $labortype = config('rbooks.LABORTYPE');
        $this->view->labortype = $labortype;

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

    public function deleteLaborContract(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $id = $request->id;

        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . 'index', ['employeeid' => $employeeid])->with(NotificationMessage::DELETE_SUCCESS);
    }
}
