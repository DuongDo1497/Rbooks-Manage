<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EducationStoreRequest;
use RBooks\Services\EducationService;
use App\Constants\NotificationMessage;
use RBooks\Models\Educations;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class EducationController extends Controller
{
    public function __construct(EducationService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('user-employees.education.');
        $this->setRoutePrefix('educations-');
        $this->view->setHeading('home.Thông tin quá trình đào tạo');
    }

    public function index(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $employee = app(Employee::class)->find($employeeid_decrypt);
        $this->view->employee = $employee;

        $educationtype = config('rbooks.EDUCATIONTYPE');
        $this->view->educationtype = $educationtype;

        $this->view->collections = $this->main_service->getEducations($employeeid_decrypt);
        $this->view->setSubHeading('home.Danh sách quá trình đào tạo');
        return $this->view('index');
    }

    public function addEducation(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $educationtype = config('rbooks.EDUCATIONTYPE');

        $this->view->employeeid = $employeeid;
        $this->view->educationtype = $educationtype;

        $this->view->setSubHeading('home.Tạo mới dữ liệu');

        return $this->view('add');
    }

    public function store(EducationStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function editEducation(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $educationtype = config('rbooks.EDUCATIONTYPE');
        $this->view->educationtype = $educationtype;

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

    public function deleteEducation(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $id = $request->id;

        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . 'index', ['employeeid' => $employeeid])->with(NotificationMessage::DELETE_SUCCESS);
    }
}
