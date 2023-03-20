<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienceStoreRequest;
use RBooks\Services\ExperienceService;
use App\Constants\NotificationMessage;
use RBooks\Models\Experiences;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class ExperienceController extends Controller
{
    public function __construct(ExperienceService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('user-employees.experience.');
        $this->setRoutePrefix('experiences-');
        $this->view->setHeading('home.Thông tin kinh nghiệm làm việc');
    }

    public function index(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $employee = app(Employee::class)->find($employeeid_decrypt);
        $this->view->employee = $employee;

        $this->view->collections = $this->main_service->getExperiences($employeeid_decrypt);
        $this->view->setSubHeading('home.Danh sách kinh nghiệm làm việc');
        return $this->view('index');
    }

    public function addExperience(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $this->view->setSubHeading('home.Tạo mới dữ liệu');

        return $this->view('add');
    }

    public function store(ExperienceStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function editExperience(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;


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

    public function deleteExperience(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $id = $request->id;

        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . 'index', ['employeeid' => $employeeid])->with(NotificationMessage::DELETE_SUCCESS);
    }
}
