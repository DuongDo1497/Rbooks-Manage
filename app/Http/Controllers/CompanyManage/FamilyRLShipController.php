<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FamilyRLShipStoreRequest;
use RBooks\Services\FamilyRLShipService;
use App\Constants\NotificationMessage;
use RBooks\Models\FamilyRelationship;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class FamilyRLShipController extends Controller
{
    public function __construct(FamilyRLShipService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('user-employees.familyrlship.');
        $this->setRoutePrefix('familyrlships-');
        $this->view->setHeading('home.Thông tin quan hệ nhân thân');
    }

    public function index(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $employee = app(Employee::class)->find($employeeid_decrypt);
        $this->view->employee = $employee;

        $relationshiptype = config('rbooks.RELATIONSHIPTYPE');
        $this->view->relationshiptype = $relationshiptype;

        $this->view->collections = $this->main_service->getFamilyRLShips($employeeid_decrypt);
        $this->view->setSubHeading('home.Danh sách quan hệ nhân thân');
        return $this->view('index');
    }

    public function addFamilyRLShip(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $relationshiptype = config('rbooks.RELATIONSHIPTYPE');

        $this->view->employeeid = $employeeid;
        $this->view->relationshiptype = $relationshiptype;

        $this->view->setSubHeading('home.Tạo mới dữ liệu');

        return $this->view('add');
    }

    public function store(FamilyRLShipStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function editFamilyRLShip(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $relationshiptype = config('rbooks.RELATIONSHIPTYPE');
        $this->view->relationshiptype = $relationshiptype;

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

    public function deleteFamilyRLShip(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $id = $request->id;

        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . 'index', ['employeeid' => $employeeid])->with(NotificationMessage::DELETE_SUCCESS);
    }
}
